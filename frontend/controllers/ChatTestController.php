<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use common\models\Chat;
use common\models\ChatMessage;
use common\models\RoomMember;
use common\models\UserProfile;
use yii\web\UnprocessableEntityHttpException;

class ChatTestController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index'],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $profile = Yii::$app->user->identity->userProfile->id;

        return $this->render('index', [
            'myToken' => md5($profile),
            'csrf' => Yii::$app->request->csrfToken,
            'profile_id' => $profile,
        ]);
    }

    public function actionMessageListener()
    {
        $from = Yii::$app->request->post("from");
        $to = Yii::$app->request->post("to");
        $room_id = Yii::$app->request->post("room");

        list($type, $channel) = $this->handleValidation($from, $to, $room_id);

        $chat = new Chat();
        $chat->from_profile_id = $from;
        $chat->to_profile_id = $to;
        $chat->room_id = $room_id;
        $chat->channel = $channel;

        if ($chat->save()) {

            $message = new ChatMessage();
            $message->chat_id = $chat->id;
            $message->text = Yii::$app->request->post("message");
            $message->save();

            $mqttResponse = [
                'type' => $type,
                'from' => $from,
                'to' => $to,
                'room_id' => $room_id,
                'message' => $message->text,
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

    private function requestToSubscribeChannel($to, $channel)
    {
        $mqttResponse = [
            'type' => "requestToSubscribeChannel",
            'channel' => $channel,
        ];

        Yii::$app->mqtt->sendMessage(md5((int)$to), $mqttResponse);

        return true;
    }
}
