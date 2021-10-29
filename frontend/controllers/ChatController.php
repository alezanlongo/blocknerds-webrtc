<?php


namespace frontend\controllers;

use common\models\Chat;
use common\models\ChatForm;
use common\models\ChatMessage;
use common\models\ChatRepository;
use common\models\EditProfileForm;
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
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $message = $this->request->post('message');
        $to = $this->request->post('targetId');
        $from = Yii::$app->user->identity->userProfile->id;

        $chat = ChatRepository::getChatByRelation($from, $to);
        if (empty($chat)) {
            $chat = new Chat();
            $chat->to_profile_id = $to;
            $chat->from_profile_id = $from;

            if (!$chat->save()) {
                throw new ServerErrorHttpException("Error creating new chat");
            }
        }

        $chatMessage = new ChatMessage();
        $chatMessage->chat_id = $chat->id;
        $chatMessage->message = $message;


        if (!$chatMessage->save()) {
            throw new ServerErrorHttpException("Error saving message");
        }

        // TODO: send message mqtt

        return [
            'status' => 200,
            'data' => [
                // 'chat' => $chat,
                'message' => $chatMessage,
            ],
        ];
    }

    public function actionGetChat($withId)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // TODO: get message with pagination
        $me = Yii::$app->user->identity->userProfile->id;

        return ChatRepository::getChat($me, $withId);
    }
    public function actionRecentChat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->generateRecentChat(4);
    }
}
