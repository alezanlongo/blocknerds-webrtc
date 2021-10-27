<?php


namespace frontend\controllers;

use common\models\Chat;
use common\models\ChatForm;
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
                "only" => ['get-form'],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionOpenChat()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        // TODO: get message with pagination
        return [];
    }

   
}
