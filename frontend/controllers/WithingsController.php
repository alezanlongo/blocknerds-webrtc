<?php

namespace frontend\controllers;

use Codeception\Util\HttpCode;
use common\components\Withings\models\inline_response_200_2_body;
use Yii;
use yii\helpers\VarDumper;
use yii\httpclient\Client;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\auth\CompositeAuth;
use common\components\WithingsComponent;
use common\components\Withings\WithingsOauth;
use common\components\Withings\WithingsClient;
use yii\web\UnprocessableEntityHttpException;

class WithingsController extends \yii\web\Controller
{
    public $clientId;
    public $customerSecret;

    private $component;

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

    public function init()
    {
        parent::init();
        $this->clientId = Yii::$app->params['withings.clientId'];
        $this->customerSecret = Yii::$app->params['withings.consumerSecret'];
        $this->component = Yii::createObject(WithingsComponent::class);
    }

    public function actionIndex()
    {
        $url = (new WithingsOauth)->getAuthenticationCode();

        return $this->redirect($url);
    }

    public function actionCallback(string $code = null, string $state = null)
    {
        (new WithingsOauth)->requestToken($code);

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $this->redirect('/');
    }

    public function actionImportMeasureGetMeas()
    {
        $measures = $this->component->measureGetmeas();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }

    public function actionImportMeasureGetActivity()
    {
        $measures = $this->component->measurev2Getactivity();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }

    public function actionImportMeasureGetIntradayActivity()
    {
        $measures = $this->component->measurev2Getintradayactivity();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }

    public function actionImportMeasureGetWorkouts()
    {
        $measures = $this->component->measurev2Getworkouts();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }

    public function actionImportMeasureGetSleep()
    {
        $measures = $this->component->sleepv2Get();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }

    public function actionImportMeasureGetSleepSummary()
    {
        $measures = $this->component->sleepv2Getsummary();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $measures;
    }
}
