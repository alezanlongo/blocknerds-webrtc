<?php


namespace frontend\controllers;

use common\models\Chat;
use common\models\ChatForm;
use common\models\ChatQueries;
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

        $chat = new Chat();
        $chat->to_profile_id = $to;
        $chat->from_profile_id = $from;
        $chat->message = $message;
        $chat->save();

        // TODO: send message mqtt

        return [
            'status' => 200,
            'data' => $chat,
        ];
    }

    public function actionGetChat($withId)
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // TODO: get message with pagination
        $me = Yii::$app->user->identity->userProfile->id;
        
        return ChatQueries::getChat($me, $withId );
    }
    public function actionRecentChat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->generateRecentChat(4);
    }
}
