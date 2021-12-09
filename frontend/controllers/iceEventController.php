<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use yii\helpers\VarDumper;

class iceEventController extends \yii\web\Controller
{
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if ($action->id == 'create') {
            $this->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    /**
     * Creates a new ice event model.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->response->format = Response::FORMAT_JSON;

        $c = $this->request->post();

        VarDumper::dump($c);

        return $c;
    }
}
