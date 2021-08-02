<?php

namespace frontend\controllers;


use Yii;
use common\models\Member;
use common\models\Request;
use common\models\Room;
use common\models\User;
use Ramsey\Uuid\Rfc4122\UuidV4;
use thamtech\uuid\helpers\UuidHelper;
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
        $request = null;
        if ($user_id == $room->owner_id) {
            $is_owner = true;
        } else {
            $request = Request::find()->where(['room_id' => $room->id, 'user_id' => $user_id])->limit(1)->one();
            $status = $request->status ?? null;
            $is_allowed = $status === Request::STATUS_ALLOW;
        }

        $requests = [];
        if ($is_owner) {
            $requests = Request::find()->with("user")->where(['room_id' => $room->id, 'status' => Request::STATUS_PENDING])->all();
        }
       
        $subQuery = Member::find()
            ->where(['not in', 'user_id', Yii::$app->getUser()->getId()])
            ->andWhere(['room_id' => $room->id])
            ->select('user_id');
        $query = User::find()->where(['in', 'id', $subQuery])->select('id, username');

        $members = $query->all();

        return $this->render('index', [
            'members' => $members,
            'room_id' => $room->id,
            'is_owner' => $is_owner,
            'is_allowed' => $is_allowed,
            'status' => $status,
            'user_id' => $user_id,
            'uuid' => $uuid,
            'request' => $request,
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

        $request = Request::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if ($request) {
            if ($request->status == Request::STATUS_ALLOW) {
                return throw new TooManyRequestsHttpException("Your request to join the room was already approved.");
            } else if ($request->status == Request::STATUS_PENDING) {
                return throw new UnprocessableEntityHttpException("Your request to join the room is pending.");
            } else {
                if ($request->attempts == Request::MAX_ATTEMPTS) {
                    return throw new UnprocessableEntityHttpException("You have reached the max request attempts to join a room.");
                }
            }

            $request->attempts += 1;
            $request->status = Request::STATUS_PENDING;
        } else {
            $request = new Request();
            $request->user_id = $user_id;
            $request->room_id = $room->id;
            $request->status = Request::STATUS_PENDING;
            $request->attempts += 1;
        }

        if ($request->save()) {
            $topic = "/room/{$room->uuid}";
            $response = [
                'type' => 'request_join',
                'status' => $request->status,
                'user_id' => $user_id,
            ];

            Yii::$app->mqtt->sendMessage($topic, $response);

            return Json::encode($request);
        }

        throw new UnprocessableEntityHttpException("Something went wrong please try again later.");
    }

    public function actionJoin($action)
    {
        $uuid = $this->request->post('uuid') ?? null;
        $user_id = $this->request->post('user_id') ?? null;

        $room = $this->joinRequestCheck($uuid, $user_id);

        $request = Request::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if (!$request)
            return throw new UnprocessableEntityHttpException("Request to join the room does not exist.");

        if ($request->status != Request::STATUS_PENDING) {
            $status = strtolower($request->status == 1 ? Request::STATUS_ALLOW : Request::STATUS_DENY);
            return throw new UnprocessableEntityHttpException("Request to join the room has status $status.");
        }

        $request->status = ($action == "allow" ? Request::STATUS_ALLOW : Request::STATUS_DENY);

        Request::getDb()->transaction(function ($db) use ($request) {
            $request->save();

            if ($request->status == Request::STATUS_ALLOW) {
                $member = new Member();
                $member->user_id = $request->user_id;
                $member->room_id = $request->room_id;
                $member->save();
            }
        });

        $topic = "/room/{$room->uuid}";
        $response = [
            'type' => 'response_join',
            'status' => $request->status,
            'user_id' => $user_id,
        ];

        Yii::$app->mqtt->sendMessage($topic, $response);

        return Json::encode($request);
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
