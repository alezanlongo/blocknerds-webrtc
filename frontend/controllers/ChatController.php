<?php


namespace frontend\controllers;

use common\models\Chat;
use common\models\ChatRepository;
use common\models\RoomMember;
use common\models\User;
use common\models\UserProfile;
use DateTimeZone;
use Locale;
use ResourceBundle;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\BaseFileHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\UnprocessableEntityHttpException;
use yii\web\UploadedFile;

class ChatController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => [],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionSendMessage()
    {
        $channel_to_talk = $this->request->post('channel');
        $to = $this->request->post('to');
        $from = Yii::$app->user->identity->userProfile->id;
        $room_id = Yii::$app->request->post("room");
        list($type, $channel) = $this->handleValidation($from, $to, $room_id);

        if (!empty($channel_to_talk) && $channel !== $channel_to_talk) {
            throw new UnprocessableEntityHttpException("Channels missmatch");
        }

        $chat = new Chat();
        $chat->from_profile_id = $from;
        $chat->to_profile_id = $to;
        $chat->room_id = $room_id;
        $chat->text = Yii::$app->request->post("text");
        $chat->channel = $channel;

        if ($chat->save()) {
            $mqttResponse = [
                'type' => $type,
                'from' => $from,
                'from_username' => Yii::$app->user->identity->username,
                'to' => $to,
                'to_username' => $chat->to_profile_id ? $chat->toProfile->user->username : null,
                'room_id' => $room_id,
                'channel' => $channel,
                'message' => $chat->text,
                'created_at' => $chat->created_at
            ];

            if ($type === "oneToRoom") {
                $profileIds = RoomMember::find()
                    ->where(['room_id' => $room_id])
                    ->select('user_profile_id');

                foreach ($profileIds->all() as $member) {
                    $this->requestToSubscribeChannel($member->user_profile_id, $channel);
                }
            } else {
                $this->requestToSubscribeChannel($from, $channel);
                $this->requestToSubscribeChannel($to, $channel);
            }

            Yii::$app->mqtt->sendMessage($channel, $mqttResponse);

            return Json::encode($mqttResponse);
        }

        throw new UnprocessableEntityHttpException("Something went wrong please try again later.");
    }

    private function handleValidation($from, $to, $room_id): array
    {
        if (!empty($from) && !empty($to)) { // One to one message

            $channel = [(int)$from, (int)$to];
            sort($channel);

            if (!empty($room_id)) { // One to one message within a room

                if (
                    !RoomMember::find()->where(['room_id' => $room_id, 'user_profile_id' => $from])->exists() ||
                    !RoomMember::find()->where(['room_id' => $room_id, 'user_profile_id' => $to])->exists()
                ) {
                    throw new UnprocessableEntityHttpException("User and room mismatch.");
                }

                $type = "oneToOneRoom";
                $channel = $type . "-" . $channel[0] . "-" . $channel[1] . "-" . $room_id;
            } else { // One to one message without a room
                if (
                    !UserProfile::find()->where(['id' => $from])->exists() ||
                    !UserProfile::find()->where(['id' => $to])->exists()
                ) {
                    throw new UnprocessableEntityHttpException("User doesn't exist.");
                }

                $type = "oneToOne";
                $channel = $type . "-" . $channel[0] . "-" . $channel[1];
            }
        } else if (!empty($from) && empty($to) && !empty($room_id)) { // Message to all the participants in the rooms
            if (
                !RoomMember::find()->where(['room_id' => $room_id, 'user_profile_id' => $from])->exists()
            ) {
                throw new UnprocessableEntityHttpException("User do not belong to this room.");
            }

            $type = "oneToRoom";
            $channel = $type . "-" . $room_id;
        } else {
            throw new UnprocessableEntityHttpException("Message not allowed.");
        }

        return [$type, md5($channel)];
    }

    public function actionRequestToSubscribeChannel()
    {
        $to = $this->request->post('to');
        $from = Yii::$app->user->identity->userProfile->id;
        $room_id = Yii::$app->request->post("room");
        list($type, $channel) = $this->handleValidation($from, $to, $room_id);

        $this->requestToSubscribeChannel($from, $channel);
        $this->requestToSubscribeChannel($to, $channel);

        return Json::encode([
            'type' => $type,
            'from' => $from,
            'to' => $to,
            'room_id' => $room_id,
            'channel' => $channel,
        ]);
    }

    private function requestToSubscribeChannel($to, $channel)
    {
        $mqttResponse = [
            'type' => "requestToSubscribeChannel",
            'channel' => $channel,
        ];

        Yii::$app->mqtt->sendMessage(md5((int)$to), $mqttResponse);

        return $mqttResponse;
    }

    public function actionGetChat($channel)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // TODO: get message with pagination
        $me = Yii::$app->user->identity->userProfile->id;

        return ChatRepository::getChats($me, $channel);
    }

    public function actionRecentChat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->generateRecentChat(4);
    }
}
