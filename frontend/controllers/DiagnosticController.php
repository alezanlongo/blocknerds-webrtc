<?php

namespace frontend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\VarDumper;

class DiagnosticController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index', 'echo-test'],
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
        return $this->render('index');
    }
    
    public function actionEchoTest()
    {
        $token = Yii::$app->getUser()->getIdentity()->auth_key;
        
        if(!Yii::$app->janusApi->isTokenStoraged($token)){
            $res = Yii::$app->janusApi->addToken($token);
        }

        return $this->render('echo-test', [
            'token' => $token,
        ]);
    }
}
