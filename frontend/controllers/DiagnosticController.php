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
        $hash = hash("sha256", Yii::$app->getUser()->getId());

        if(!Yii::$app->janusApi->isTokenStoraged($hash)){
            $res = Yii::$app->janusApi->addToken($hash);
        }

        return $this->render('echo-test', [
            'token' => $hash,
        ]);
    }
}
