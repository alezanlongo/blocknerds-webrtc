<?php

namespace frontend\controllers;

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

class WithingController extends \yii\web\Controller
{
    public $baseUrl = "https://account.withings.com/";
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

    public function actionImportMeasureGetmeas()
    {
        $measures = $this->component->getMeasureGetmeas();

        // $measures->save();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return $measures;
    }
}
