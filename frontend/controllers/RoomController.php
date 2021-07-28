<?php

namespace frontend\controllers;


use Yii;
use common\models\Member;
use common\models\Room;
use common\models\User;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\web\TooManyRequestsHttpException;
use yii\web\UnprocessableEntityHttpException;

class RoomController extends \yii\web\Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                "class" => AccessControl::class,
                "only" => ['index', "create"],
                "rules" => [
                    [
                        'allow' => true,
                        'roles' => ["@"],
                    ]
                ],
            ],
        ];
    }

    public function actionIndex($uuid)
    {
        $room = Room::find()->where(['uuid' => $uuid])->limit(1)->one();

        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $user_id = Yii::$app->user->getId();

        $is_owner = false;
        $is_allowed = false;
        $status = null;
        if ($user_id == $room->owner_id) {
            $is_owner = true;
        } else {
            $member = Member::find()->where(['room_id' => $room->id, 'user_id' => $user_id])->limit(1)->one();
            $status = $member->status ?? null;
            $is_allowed = $status === Member::STATUS_ALLOW;
        }

        $requests = [];
        if ($is_owner) {
            $requests = Member::find()->with("user")->where(['room_id' => $room->id, 'status' => Member::STATUS_PENDING])->all();
        }
       
        // $subQuery = Member::find()
        //     ->where(['not in', 'user_id', Yii::$app->getUser()->getId()])
        //     ->andWhere(['room_id' => $room->id, 'status' => Member::STATUS_ALLOW])
        //     ->select('user_id');
        // $query = User::find()->where(['in', 'id', $subQuery]);

        // $members = $query->all();

        return $this->render('index', [
            // 'members' => $members,
            'room_id' => $room->id,
            'is_owner' => $is_owner,
            'is_allowed' => $is_allowed,
            'status' => $status,
            'user_id' => $user_id,
            'uuid' => $uuid,
            'requests' => $requests,
        ]);
    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $userId = Yii::$app->user->identity->getId();
            $model = new \common\models\Room();
            $fields['Room']['owner_id'] = $userId;
            $fields['Room']['scheduled_at'] = time();

            if ($model->load($fields) && $model->save()) {
                $memberOwner = new Member();
                $memberOwner->room_id = $model->id;
                $memberOwner->user_id = $userId;
                $memberOwner->status = Member::STATUS_ALLOW;
                $memberOwner->save();

                Yii::$app->janusApi->videoRoomCreate($model->id);
                
                return $this->redirect([$model->uuid]);
            }
        }

        return $this->render('create');
    }

    public function actionJoinRequest()
    {
        $uuid = $this->request->post('uuid') ?? null;
        $user_id = $this->request->post('user_id') ?? null;

        $room = $this->joinRequestCheck($uuid, $user_id);

        $member = Member::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if ($member) {
            if ($member->status == Member::STATUS_DENY) {
                return throw new UnprocessableEntityHttpException("Your request to join the room has been denied.");
            } else if ($member->status == Member::STATUS_PENDING) {
                return throw new TooManyRequestsHttpException("Your request to join the room is pending.");
            } else {
                return throw new TooManyRequestsHttpException("Your request to join the room was already approved.");
            }
        }

        $model = new Member();
        $model->user_id = $user_id;
        $model->room_id = $room->id;
        $model->status = Member::STATUS_PENDING;

        if ($model->save()) {
            $topic = 'room';
            $response = [
                'type' => 'Message Arrived',
                'member' => $model
            ];

            Yii::$app->mqtt->sendMessage($topic, $response);

            return Json::encode($model);
        }

        throw new UnprocessableEntityHttpException("Something went wrong please try again later.");
    }

    public function actionJoin($action)
    {
        $uuid = $this->request->post('uuid') ?? null;
        $user_id = $this->request->post('user_id') ?? null;

        $room = $this->joinRequestCheck($uuid, $user_id);

        $member = Member::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if (!$member) {
            return throw new UnprocessableEntityHttpException("Request to join the room don't exist.");
        }

        $member->status = ($action == "allow" ? Member::STATUS_ALLOW : Member::STATUS_DENY);

        if ($member->save()) {

            $topic = 'room';

            $response = [
                'type' => 'Message Arrived',
                'member' => Json::encode($member),
                'status' => $member->status
            ];

            Yii::$app->mqtt->sendMessage($topic, $response);

            return Json::encode($member);
        }

        throw new UnprocessableEntityHttpException("Something went wrong please try again later.");
    }

    private function joinRequestCheck($uuid = null, $user_id = null)
    {
        if (!$uuid || !$user_id) {
            return throw new UnprocessableEntityHttpException("One or more parameters are empty.");
        }

        $room = Room::find()->where(['uuid' => $uuid])->limit(1)->one();

        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $user = User::find()->where(['id' => $user_id])->limit(1)->one();

        if (!$user) {
            return throw new NotFoundHttpException("User not found.");
        }

        if ($room->owner_id == $user->id) {
            return throw new UnprocessableEntityHttpException("Owner is member by default.");
        }

        return $room;
    }
}
