<?php

namespace frontend\controllers;

use common\models\IceEventLog;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\web\UnprocessableEntityHttpException;

class IceEventController extends \yii\web\Controller
{

    private const RESPONSE_OK = "OK";
    private const RESPONSE_KO = "KO";

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index', 'create'],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ]
                ],
            ],
        ];
    }

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

    public function actionIndex()
    {
        $dataProvider = IceEventLog::find()
            ->where(['profile_id' =>  Yii::$app->user->identity->userProfile->id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(20)->all();
        $logs = array_map(function ($log) {
            return [
                'id' => $log->id,
                'candidate' => $log->log['candidate'],
                // 'sdp' => $log->sdp_log,
                'created_at' => $log->created_at,
            ];
        }, $dataProvider);

        return $this->render('index', [
            'logs' => $logs,
        ]);
    }

    public function actionGetLog(string $id)
    {
        $this->response->format = Response::FORMAT_JSON;
        $log = IceEventLog::findOne($id);

        return [
            'id' => $log->id,
            'ice' => $log->log,
            'sdp' => $log->sdp_log,
            'created_at' => $log->created_at,
        ];
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
            // VarDumper::dump($dataLog);
            // die;
            $iceEvent = new IceEventLog();
            $iceEvent->log = $dataLog['ice'] ?? null;
            $iceEvent->sdp_log = $dataLog['sdp'] ?? null;
            $iceEvent->save();

            return ['status' => 200] + $dataLog;
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
}
