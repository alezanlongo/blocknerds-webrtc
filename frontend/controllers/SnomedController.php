<?php

namespace frontend\controllers;

use Yii;
use common\components\SnomedComponent;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;


class SnomedController extends Controller
{
    private $component;

    public function init()
    {
        parent::init();
        if($user = Yii::$app->user->identity){
            $this->component = Yii::createObject(SnomedComponent::class);
        }
    }


    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                "class" => AccessControl::class,
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionSearch($q = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'name' => '']];

        if (!is_null($q)) {

            $out['results'] =  $this->component->searchByTerm($q);

        }

        return $out;
    }

}
