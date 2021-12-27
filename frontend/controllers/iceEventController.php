<?php

namespace frontend\controllers;

use Carbon\Carbon;
use common\models\IceEventLog;
use common\models\Menu;
use common\models\Room;
use common\models\RoomMember;
use common\models\Tree;
use common\models\UserProfile;
use Exception;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Response;
use yii\helpers\VarDumper;
use yii\web\NotFoundHttpException;
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
            // ->where(['profile_id' =>  Yii::$app->user->identity->userProfile->id])
            ->orderBy(['id' => SORT_DESC])
            ->limit(20)->all();
        $logs = array_map(function ($log) {
            $roomMember = $log->roomMember;
            return [
                'id' => $log->id,
                'candidate' => $log->log['candidate'],
                'created_at' => $log->created_at,
                'profile' => [
                    'id' => $log->profile_id,
                    'username' => $roomMember->userProfile->user->username,
                    'room_uuid' => $roomMember->room->uuid,
                ],
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
        $dataLog = $this->request->post();
        try {
            $roomMember = $this->getRoomMember($dataLog['uuid'], intval($dataLog['userProfileId']));
            $rootRoomLog = Tree::findOne(['name'=>$roomMember->room->uuid]);
            if(!$rootRoomLog){
                $rootRoomLog = new Tree(['name' => $dataLog['uuid']]);
                $rootRoomLog->makeRoot();
            }
            $rootUserLog = new Tree(['name' => $roomMember->user->username]);
            $rootUserLog->prependTo($rootRoomLog);

            foreach ($dataLog['logs'] as $k => $log) {
                $iceEvent = new IceEventLog();
                $iceEvent->log = $log['ice'] ?? null;
                $iceEvent->sdp_log = $log['sdp'] ?? null;
                $iceEvent->profile_id = $roomMember->user_profile_id;
                $iceEvent->room_id = $roomMember->room_id;
                $iceEvent->save();
                $log = new Tree(['name' => Carbon::createFromTimestamp($iceEvent->created_at, $roomMember->userProfile->timezone)->format('Y-m-d H:i:s')]);
                $log->prependTo($rootUserLog);
            }

            return ['status' => 200];
        } catch (Exception $e) {
            throw new UnprocessableEntityHttpException($e->getMessage());
        }
    }
    private function getRoomMember(string $uuid, int $profileId): RoomMember
    {
        $room = Room::findOne(['uuid' => $uuid]);
        if (!$room) {
            throw new NotFoundHttpException("Room not found.");
        }
        
        $roomMember = RoomMember::findOne(['room_id' => $room->id, 'user_profile_id' => $profileId]);
        if(!$roomMember){
            throw new NotFoundHttpException("Member-room relationship not found.");
        }

        return $roomMember;
    }
}
