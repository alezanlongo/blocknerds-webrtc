<?php

namespace frontend\controllers;

use Yii;
use yii\web\Response;
use common\components\JanusEventLoggerComponent;
use yii\web\UnprocessableEntityHttpException;

class JanusEventController extends \yii\web\Controller
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
     * Creates a new Event model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $this->response->format = Response::FORMAT_JSON;

        if (!Yii::$app->params['janus.eventHandler']) {
            return throw new UnprocessableEntityHttpException("Janus event handler is disabled.");
        }

        $c = $this->request->post();
        /** @var JanusEventLoggerComponent $je */
        $je = yii::$app->janusEvents;
        $je->pushEvent($c);

        return $c;
    }
}
