<?php

namespace frontend\controllers;


use Yii;
use common\models\RoomMember;
use common\models\RoomRequest;
use common\models\Room;
use common\models\User;
use DateTime;
use Ramsey\Uuid\Rfc4122\UuidV4;
use thamtech\uuid\helpers\UuidHelper;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
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
        $limit_members = Yii::$app->params['janus.roomMaxMembersAllowed'];
        $is_owner = false;
        $is_allowed = false;
        $status = null;
        $request = null;
        if ($user_id == $room->owner_id) {
            $is_owner = true;
        } else {
            $request = RoomRequest::find()->where(['room_id' => $room->id, 'user_id' => $user_id])->limit(1)->one();
            $status = $request->status ?? null;
            $is_allowed = $status === RoomRequest::STATUS_ALLOW;
        }

        $requests = [];
        if ($is_owner) {
            $requests = RoomRequest::find()->with("user")->where(['room_id' => $room->id, 'status' => RoomRequest::STATUS_PENDING])->all();
        }

        $subQuery = RoomMember::find()
            ->andWhere(['room_id' => $room->id])
            ->select('user_id');
        $query = User::find()->where(['in', 'id', $subQuery])->select('id, username');

        $members = $query->asArray()->all();

        if (count($members) > $limit_members) {
            var_dump("No possible add more members can't be in this room. The limit is " . $limit_members);
            die;
        }
        $members = $query->all();
        if ($is_owner || $is_allowed || Yii::$app->janusApi->videoRoomExists($uuid) === true) {
            $userToken = RoomMember::find()->select('token')->where(['user_id' => $user_id, 'room_id' => $room->id])->limit(1)->one();
            $token = \str_replace('-', '', ($userToken->token ?? null));
            $res = Yii::$app->janusApi->addUserToken($uuid, $token);
        }

        return $this->render('index', [
            //'token' => Yii::$app->janusApi->createHmacToken(),
            'token' => $token, //storedToken
            'limit_members' => $limit_members,
            'members' => $members,
            'room_id' => $room->id,
            'is_owner' => $is_owner,
            'is_allowed' => $is_allowed,
            'status' => $status,
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
            $fields['Room']['title'] = Room::DEFAULT_TITLE;
            $fields['Room']['owner_id'] = $userId;
            $fields['Room']['duration'] = Room::DEFAULT_DURATION;
            $fields['Room']['scheduled_at'] = time();

            if ($model->load($fields) && $model->save()) {
                $memberOwner = new RoomMember();
                $memberOwner->room_id = $model->id;
                $memberOwner->user_id = $userId;
                $memberOwner->save();

                Yii::$app->janusApi->videoRoomCreate($model->uuid);

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

        $request = RoomRequest::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if ($request) {
            if ($request->status == RoomRequest::STATUS_ALLOW) {
                return throw new TooManyRequestsHttpException("Your request to join the room was already approved.");
            } else if ($request->status == RoomRequest::STATUS_PENDING) {
                return throw new UnprocessableEntityHttpException("Your request to join the room is pending.");
            } else {
                if ($request->attempts == RoomRequest::MAX_ATTEMPTS) {
                    return throw new UnprocessableEntityHttpException("You have reached the max request attempts to join a room.");
                }
            }

            $request->attempts += 1;
            $request->status = RoomRequest::STATUS_PENDING;
        } else {
            $request = new RoomRequest();
            $request->user_id = $user_id;
            $request->room_id = $room->id;
            $request->status = RoomRequest::STATUS_PENDING;
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

        $request = RoomRequest::find()->where([
            'room_id' => $room->id,
            'user_id' => $user_id
        ])->limit(1)->one();

        if (!$request)
            return throw new UnprocessableEntityHttpException("Request to join the room does not exist.");

        if ($request->status != RoomRequest::STATUS_PENDING) {
            $status = strtolower($request->status == 1 ? RoomRequest::STATUS_ALLOW : RoomRequest::STATUS_DENY);
            return throw new UnprocessableEntityHttpException("Request to join the room has status $status.");
        }

        $request->status = ($action == "allow" ? RoomRequest::STATUS_ALLOW : RoomRequest::STATUS_DENY);

        RoomRequest::getDb()->transaction(function ($db) use ($request) {
            $request->save();

            if ($request->status == RoomRequest::STATUS_ALLOW) {
                $member = new RoomMember();
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

    public function actionUserList($q = null, $id = null, $room_id = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $out = ['results' => ['id' => '', 'username' => '']];

        if (!is_null($q)) {

            $users = User::find()
                ->select(['id', 'username'])
                ->where(['status' => User::STATUS_ACTIVE])
                ->andWhere(['LIKE', 'username', $q])
                ->andWhere(['NOT IN', 'id', Yii::$app->user->identity->getId()])
                ->limit(10);

            if (!is_null($room_id)) {
                $idMembers = RoomMember::find()->where(["room_id" => $room_id])->select(['user_id']);
                $users->andWhere(['NOT IN', 'id', $idMembers]);
            }

            $out['results'] = array_values($users->all());
        } elseif ($id > 0) {
            $out['results'] = ['id' => $id, 'username' => User::find($id)->username];
        }

        return $out;
    }

    public function actionCreateSchedule()
    {
        if (Yii::$app->request->isPost) {
            $model = new \common\models\Room();

            $fields['Room']['title'] = Yii::$app->request->post("title");

            $userId = Yii::$app->user->identity->getId();
            $fields['Room']['owner_id'] = $userId;

            $fields['Room']['duration'] = Yii::$app->request->post("duration");

            $datetimepicker = new DateTime(Yii::$app->request->post("datetimepicker"));
            $fields['Room']['scheduled_at'] = $datetimepicker->getTimestamp();

            $members = Yii::$app->request->post("User");

            if ($model->load($fields) && $model->save()) {

                $member = new RoomMember();
                $member->user_id = $userId;
                $member->room_id = $model->id;
                $member->save();

                foreach ($members["username"] as $k => $id) {
                    $member = new RoomMember();
                    $member->user_id = (int)$id;
                    $member->room_id = $model->id;
                    $member->save();
                }

                return Json::encode($model);
            }
        }

        return throw new UnprocessableEntityHttpException();
    }

    public function actionUpdateSchedule()
    {
        if (Yii::$app->request->isPost) {
            $room_id = $this->request->post('room_id') ?? null;

            $room = Room::findOne($room_id);

            $fields['Room']['title'] = Yii::$app->request->post("title", $room->title);

            $fields['Room']['duration'] = Yii::$app->request->post("duration", $room->duration);

            $datetimepicker = $room->scheduled_at;
            if (Yii::$app->request->post("datetimepicker")) {
                $datetimepicker = new DateTime(Yii::$app->request->post("datetimepicker"));
                $datetimepicker = $datetimepicker->getTimestamp();
            }
            $fields['Room']['scheduled_at'] = $datetimepicker;

            $members = Yii::$app->request->post("User");

            if ($room->load($fields) && $room->save()) {

                $oldMembers = $room->getMembers()->all();
                foreach ($oldMembers as $member) {
                    $member->delete();
                }

                foreach ($members["username"] as $k => $id) {
                    $member = new RoomMember();
                    $member->user_id = (int)$id;
                    $member->room_id = $room->id;
                    $member->save();
                }

                return Json::encode($room);
            }
        }

        return throw new UnprocessableEntityHttpException();
    }

    function actionCalendar()
    {
        $formatter = \Yii::$app->formatter;

        $user_id = Yii::$app->user->getId();
        $roomSelected = null;
        $roomMembers = [];

        if (Yii::$app->request->isAjax) {
            $room_id = Yii::$app->request->get("room_id", 0);

            $roomSelected = Room::findOne($room_id);

            $roomMembers = $roomSelected->getMembers()->all();
        }

        return $this->render('calendar', [
            'formatter' => $formatter,
            'user_id' => $user_id,
            "roomSelected" => $roomSelected,
            "roomMembers" => $roomMembers
        ]);
    }

    function actionFetchCalendarEvents($user_id)
    {
        $formatter = \Yii::$app->formatter;

        $subQuery = RoomMember::find()->where(["user_id" => $user_id])->select(['room_id']);
        $data = Room::find()->where(['in', 'id', $subQuery])->all();

        $events = [];
        foreach ($data as $key => $value) {
            $events[$key]['room_id'] = $value->id;
            $events[$key]['title'] = $value->title;
            $events[$key]['duration'] = $value->duration;
            $events[$key]['start'] = $formatter->asDate($value->scheduled_at, 'php:Y-m-d m:i:00');
        }

        return Json::encode($events);
    }
}
