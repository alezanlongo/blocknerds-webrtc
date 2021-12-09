<?php

namespace frontend\controllers;

use common\models\IceEventLog;
use Exception;
use Yii;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\web\UnprocessableEntityHttpException;

class IceEventController extends \yii\web\Controller
{

    private const RESPONSE_OK = "OK";
    private const RESPONSE_KO = "KO";
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

        try {
            $dataLog = $this->request->post();
            $iceEvent = new IceEventLog();
            $iceEvent->log = $dataLog;
            $iceEvent->save();

            return ['status' => 200] + $dataLog;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
