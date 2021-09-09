<?php

namespace frontend\controllers;

use Yii;
use DateTime;
use Carbon\Carbon;
use common\components\JanusApiComponent;
use yii\helpers\Html;
use yii\helpers\Json;
use common\models\Room;
use common\models\User;
use common\models\Meeting;
use common\models\RoomMember;
use common\models\RoomRequest;
use common\models\UserProfile;
use common\models\UserSetting;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use common\models\RoomMemberRepository;
use yii\web\TooManyRequestsHttpException;
use yii\web\UnprocessableEntityHttpException;
use common\widgets\cardNextOrInProgressMeeting\cardNextOrInProgressMeetingWidget;
use yii\helpers\Url;
use yii\web\Response;

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
                "only" => ['index', "create", "calendar"],
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
        $this->layout = 'room';
        $room = Room::find()->where(['uuid' => $uuid])->limit(1)->one();

        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $meeting = $room->getMeeting()->one();

        if (!$meeting) {
            return throw new NotFoundHttpException("Meeting not found.");
        }

        $user = Yii::$app->user->identity;
        $profile = $user->getUserProfile()->one();

        $limit_members = Yii::$app->params['janus.roomMaxMembersAllowed'];
        $is_owner = false;
        $is_allowed = false;
        $status = null;
        $request = null;

        if ($profile->id == $meeting->owner_id) {
            $is_owner = true;
        } else {
            $request = RoomRequest::find()->where(['room_id' => $room->id, 'user_profile_id' => $profile->id])->limit(1)->one();
            $status = $request->status ?? null;
            $is_allowed = $status === RoomRequest::STATUS_ALLOW;
        }

        $requests = [];
        if ($is_owner) {
            $requests = RoomRequest::find()
                ->where(['room_id' => $room->id, 'status' => RoomRequest::STATUS_PENDING])
                ->leftJoin('user_profile', 'user_profile_id = id')
                ->all();
        }

        $profileIds = RoomMember::find()
            ->andWhere(['room_id' => $room->id])
            ->select('user_profile_id');

        $usersIds = UserProfile::find()->where(['in', 'id', $profileIds])
            ->select('user_id');

        $users = User::find()->where(['in', 'id', $usersIds])
            ->select('id, username');

        $members = $users->asArray()->all();

        if (count($members) > $limit_members) {
            var_dump("No possible add more members can't be in this room. The limit is " . $limit_members);
            die;
        }

        $members = $users->all();

        $token = null;
        if (($is_owner || $is_allowed) && Yii::$app->janusApi->videoRoomExists($uuid) === true && $room->is_quick) {
            $userToken = RoomMember::find()->select('token')->where(['user_profile_id' => $profile->id, 'room_id' => $room->id])->limit(1)->one();
            $token = $userToken->token;
            $uTokens = Yii::$app->janusApi->getMembersTokenByRoom($uuid);
            if (false !== $uTokens && (empty($uTokens) || !\in_array($token, \array_column($uTokens, 'token')))) {
                $res = Yii::$app->janusApi->addUserToken($uuid, $token);
            }
        }
        if (($is_owner || $is_allowed) && Yii::$app->janusApi->videoRoomExists($uuid) === true && !$room->is_quick) {
        }

        $inRoomMembersIds = [];
        $irm = Yii::$app->janusApi->getInRoomMembers($uuid);
        if (!empty($irm)) {
            $inRoomMembersIds = \array_column(\array_filter($irm, function ($v) use ($token) {
                if (null !== $token && isset($v['token']) && $v['token'] == $token) {
                    return false;
                }
                return true;
            }), "id");
        }


        // \print_r([$this->request->isAjax,$this->request->isPost,$this->request->get('mute', null),null !== $token]);
        if ($this->request->isAjax && $this->request->isPost && $this->request->get('mute', null) && null !== $token) {
            if (!$this->request->post('muteTarget', false)) {
                $this->response->format = Response::FORMAT_JSON;
                // $myJanusMember = \array_filter($irm, function ($v) use ($token) {
                //     if (null !== $token && isset($v['token']) && $v['token'] == $token) {
                //         return true;
                //     }
                //     return false;
                // });
                // if (empty($myJanusMember)) {
                //     $this->response->format = Response::FORMAT_JSON;
                //     $this->response->statusCode = 403;
                //     return $this->response;
                // }
                $this->response->statusCode = 403;
                //\print_r( $this->request->get('mute'));
                if (Yii::$app->janusApi->moderateMember($uuid, $token, JanusApiComponent::SOURCE_AUDIO, $this->request->get('mute') == 'true' ? true : false)) {
                    $this->response->statusCode = 200;
                }
                return $this->response;
            }
        }

        $meeting = $room->getMeeting()->one();
        $endTime = $meeting->scheduled_at + $meeting->duration;

        return $this->render('index', [
            //'token' => Yii::$app->janusApi->createHmacToken(),
            'token' => $token, //storedToken
            'user_profile_id' => $profile->id,
            'limit_members' => $limit_members,
            'in_room_members' => $inRoomMembersIds,
            'members' => $members,
            'room_id' => $room->id,
            'is_owner' => $is_owner,
            'is_allowed' => $is_allowed,
            'status' => $status,
            'uuid' => $uuid,
            'request' => $request,
            'requests' => $requests,
            'endTime' => $endTime
        ]);
    }

    public function actionCreate()
    {
        $user = Yii::$app->user->identity;
        $profile = $user->getUserProfile()->one();

        $meeting = new Meeting();

        $fields['Meeting']['title'] = Meeting::DEFAULT_TITLE;
        $fields['Meeting']['owner_id'] = $profile->id;
        $fields['Meeting']['duration'] = Meeting::DEFAULT_DURATION;
        $fields['Meeting']['scheduled_at'] = time();
        $fields['Meeting']['reminder_time'] = 0;
        $fields['Meeting']['allow_waiting'] = 1;

        if ($meeting->load($fields) && $meeting->save()) {
            $room = new Room();
            $room->meeting_id = $meeting->id;
            $room->is_quick = true;
            $room->status = Room::STATUS_CREATED;
            $room->save();

            Yii::$app->janusApi->videoRoomCreate($room->uuid);

            $memberOwner = new RoomMember();
            $memberOwner->room_id = $room->id;
            $memberOwner->user_profile_id = $profile->id;
            $memberOwner->save();


            return $this->redirect([$room->uuid]);
        }
    }

    public function actionJoinRequest()
    {
        $uuid = $this->request->post('uuid') ?? null;
        $user_profile_id = $this->request->post('user_profile_id') ?? null;

        $room = $this->joinRequestCheck($uuid, $user_profile_id);

        $request = RoomRequest::find()->where([
            'room_id' => $room->id,
            'user_profile_id' => $user_profile_id
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
            $request->user_profile_id = $user_profile_id;
            $request->room_id = $room->id;
            $request->status = RoomRequest::STATUS_PENDING;
            $request->attempts += 1;
        }

        if ($request->save()) {
            $topic = "/room/{$room->uuid}";
            $response = [
                'type' => 'request_join',
                'status' => $request->status,
                'user_profile_id' => $user_profile_id,
            ];

            Yii::$app->mqtt->sendMessage($topic, $response);

            return Json::encode($request);
        }

        throw new UnprocessableEntityHttpException("Something went wrong please try again later.");
    }

    public function actionJoin($action)
    {
        $uuid = $this->request->post('uuid') ?? null;
        $user_profile_id = $this->request->post('user_profile_id') ?? null;

        $room = $this->joinRequestCheck($uuid, $user_profile_id);

        $request = RoomRequest::find()->where([
            'room_id' => $room->id,
            'user_profile_id' => $user_profile_id
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
                $member->user_profile_id = $request->user_profile_id;
                $member->room_id = $request->room_id;
                $member->save();
            }
        });

        $topic = "/room/{$room->uuid}";
        $response = [
            'type' => 'response_join',
            'status' => $request->status,
            'user_profile_id' => $user_profile_id,
        ];

        Yii::$app->mqtt->sendMessage($topic, $response);

        return Json::encode($request);
    }

    private function joinRequestCheck($uuid = null, $user_profile_id = null)
    {
        if (!$uuid || !$user_profile_id) {
            return throw new UnprocessableEntityHttpException("One or more parameters are empty.");
        }

        $room = Room::find()->where(['uuid' => $uuid])->limit(1)->one();

        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $meeting = $room->getMeeting()->one();

        if (!$meeting) {
            return throw new NotFoundHttpException("Meeting not found.");
        }

        $profile = UserProfile::find()->where(['id' => $user_profile_id])->limit(1)->one();

        if (!$profile) {
            return throw new NotFoundHttpException("User not found.");
        }

        if ($meeting->owner_id == $profile->id) {
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
                ->select(['user_profile.id', '"user".username'])
                ->where(['"user".status' => User::STATUS_ACTIVE])
                ->andWhere(['LIKE', '"user".username', $q])
                ->andWhere(['NOT IN', '"user".id', Yii::$app->user->identity->getId()])
                ->leftJoin('user_profile', 'user_profile.user_id = "user".id')
                ->limit(10);

            if (!is_null($room_id)) {
                $idMembers = RoomMember::find()->where(["room_id" => $room_id])->select(['user_profile_id']);
                $users->andWhere(['NOT IN', 'user_profile.id', $idMembers]);
            }

            $out['results'] = array_values($users->all());
        }

        return $out;
    }

    public function actionCreateSchedule()
    {
        $user = Yii::$app->user->identity;
        $profile = $user->getUserProfile()->one();

        $meeting = new Meeting();

        $fields['Meeting']['title'] =  Yii::$app->request->post("title");
        $fields['Meeting']['description'] =  Yii::$app->request->post("description", null);
        $fields['Meeting']['owner_id'] = $profile->id;
        $fields['Meeting']['duration'] = Yii::$app->request->post("duration");

        $datetimepicker = new DateTime(Yii::$app->request->post("datetimepicker"));
        $fields['Meeting']['scheduled_at'] = $datetimepicker->getTimestamp();

        $fields['Meeting']['reminder_time'] = (int)Yii::$app->request->post("reminder_time", 0);
        $fields['Meeting']['allow_waiting'] = (bool)Yii::$app->request->post("allow_waiting", 0);

        $members = Yii::$app->request->post("username");

        if ($meeting->load($fields) && $meeting->save()) {
            $room = new Room();
            $room->meeting_id = $meeting->id;
            $room->is_quick = false;
            $room->status = Room::STATUS_PENDING;
            $room->save();

            $member = new RoomMember();
            $member->room_id = $room->id;
            $member->user_profile_id = $profile->id;
            $member->save();

            foreach ($members as $k => $id) {
                $member = new RoomMember();
                $member->user_profile_id = (int)$id;
                $member->room_id = $room->id;
                $member->save();
            }

            return Json::encode($room);
        }

        return throw new UnprocessableEntityHttpException();
    }

    public function actionUpdateSchedule()
    {
        if (Yii::$app->request->isPost) {
            $room_id = $this->request->post('room_id');

            $room = Room::findOne($room_id);

            $meeting = $room->getMeeting()->one();

            $fields['Meeting']['title'] = Yii::$app->request->post("title", $meeting->title);
            $fields['Meeting']['description'] = Yii::$app->request->post("description", $meeting->description);
            $fields['Meeting']['duration'] = Yii::$app->request->post("duration", $meeting->duration);
            $fields['Meeting']['reminder_time'] = Yii::$app->request->post("reminder_time", $meeting->reminder_time);

            $datetimepicker = $meeting->scheduled_at;
            if (Yii::$app->request->post("datetimepicker")) {
                $datetimepicker = new DateTime(Yii::$app->request->post("datetimepicker"));
                $datetimepicker = $datetimepicker->getTimestamp();
            }
            $fields['Meeting']['scheduled_at'] = $datetimepicker;

            if ($meeting->load($fields) && $meeting->save()) {

                if ($members = Yii::$app->request->post("User")) {

                    $oldMembers = $room->getRoomMembers()->all();

                    foreach ($oldMembers as $member) {
                        $member->delete();
                    }

                    foreach ($members["username"] as $k => $id) {
                        $member = new RoomMember();
                        $member->user_profile_id = (int)$id;
                        $member->room_id = $room->id;
                        $member->save();
                    }
                }

                return Json::encode($meeting);
            }
        }

        return throw new UnprocessableEntityHttpException();
    }

    function actionCalendar()
    {
        $user = Yii::$app->user->identity;
        $profile = $user->getUserProfile()->one();

        if (Yii::$app->request->isPost) {

            $value = $this->request->post('initialView');

            if ($user && $value) {
                $userSetting = UserSetting::setValue($user->id, 'initialView', UserSetting::GROUP_NAME_CALENDAR, $value);

                return Json::encode($userSetting);
            }

            return throw new UnprocessableEntityHttpException();
        }

        $roomSelected = null;
        $roomMembers = [];
        $initialView = UserSetting::getSetting($user->id, 'initialView', UserSetting::GROUP_NAME_CALENDAR);

        $cardNextOrInProgressMeetingWidget = null;
        if (Yii::$app->request->isAjax && $this->request->get('_pjax') == "#calendar-next-meeting") {
            $subQuery = RoomMember::find()->where(["user_profile_id" => $profile->id])->select(['room_id']);
            $rooms = Room::find()->where(['in', 'id', $subQuery])->select(['meeting_id']);
            $nearestMeeting = Meeting::find()
                ->where(['in', 'id', $rooms])
                ->andWhere('to_timestamp(scheduled_at+duration) >= NOW()')
                ->orderBy(['scheduled_at' => 'SORT_ASC'])
                ->one();

            if ($nearestMeeting) {

                if (Carbon::now()->between(
                    Carbon::createFromTimestamp($nearestMeeting->scheduled_at),
                    Carbon::createFromTimestamp($nearestMeeting->scheduled_at)->addSeconds($nearestMeeting->duration)
                )) {
                    $cardNextOrInProgressMeetingWidget = cardNextOrInProgressMeetingWidget::widget([
                        'title' => 'In progress',
                        'text' => $nearestMeeting->title . ', started ' . Yii::$app->formatter->format($nearestMeeting->scheduled_at, 'relativeTime'),
                        'url' => Url::to('room/' . $nearestMeeting->room->uuid),
                    ]);
                } else {
                    $text = $nearestMeeting->title . ', starts in ' . Carbon::createFromTimestamp($nearestMeeting->scheduled_at)->diffForHumans();

                    $cardNextOrInProgressMeetingWidget = cardNextOrInProgressMeetingWidget::widget([
                        'title' => 'Next meeting',
                        'text' => $text,
                        'url' => Url::to('room/' . $nearestMeeting->room->uuid),
                    ]);
                }
            }
        }

        if (Yii::$app->request->isAjax && $this->request->get('_pjax') == "#calendar-request") {
            $room_id = Yii::$app->request->get("room_id", 0);

            $roomSelected = Room::findOne($room_id);

            $roomMembers = $roomSelected->getRoomMembers()->all();
        }

        return $this->render('calendar', [
            'user_profile_id' => $profile->id,
            'roomSelected' => $roomSelected,
            'roomMembers' => $roomMembers,
            'initialView' => $initialView ? $initialView->value : 'dayGridWeek',
            'cardNextOrInProgressMeetingWidget' => $cardNextOrInProgressMeetingWidget
        ]);
    }

    function actionFetchCalendarEvents($id)
    {
        $formatter = \Yii::$app->formatter;

        $subQuery = RoomMember::find()->where(["user_profile_id" => $id])->select(['room_id']);
        $rooms = Room::find()->where(['in', 'id', $subQuery])->all();

        $events = [];
        foreach ($rooms as $key => $room) {
            $events[$key]['meeting_id'] = $room->meeting_id;
            $events[$key]['room_id'] = $room->id;
            $events[$key]['title'] = $room->meeting->title;
            $events[$key]['duration'] = $room->meeting->duration;
            $events[$key]['start'] = $formatter->asDate($room->meeting->scheduled_at, 'php:Y-m-d m:i:00');
        }

        return Json::encode($events);
    }

    // public function actionTimeExpired()
    // {
    //     $uuid = $this->request->post('uuid') ?? null;
    //     $user_id = $this->request->post('user_id') ?? null;

    //     // $room = $this->joinRequestCheck($uuid, $user_id);

    //     $topic = "/room/{$uuid}";
    //     $response = [
    //         'type' => 'request_time_over',
    //         // 'user_id' => $user_id,
    //     ];

    //     Yii::$app->mqtt->sendMessage($topic, $response);

    //     return Json::encode($uuid);
    // }

    // public function actionAddTime()
    // {
    //     $uuid = $this->request->post('uuid') ?? null;
    //     $user_id = $this->request->post('user_id') ?? null;

    //     // $room = $this->joinRequestCheck($uuid, $user_id);

    //     $topic = "/room/{$uuid}";
    //     $response = [
    //         'type' => 'response_time_over_add',
    //     ];

    //     Yii::$app->mqtt->sendMessage($topic, $response);

    //     return Json::encode($uuid);
    // }

    public function actionToggleMedia()
    {
        $uuid = $this->request->post('uuid') ?? null;
        $profile_id = $this->request->post('user_profile_id') ?? null;
        $video = $this->request->post('video') ?? null;
        $audio = $this->request->post('audio') ?? null;

        $room = Room::find()->where(['uuid' => $uuid])->limit(1)->one();
        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $profile = Room::find()->where(['id' => $profile_id])->limit(1)->one();
        if (!$profile) {
            return throw new NotFoundHttpException("Profile not found.");
        }

        $roomMember = RoomMember::find()
            ->where(['user_profile_id' => $profile->id, 'room_id' => $room->id])
            ->limit(1)->one();

        if (!$roomMember) {
            return throw new NotFoundHttpException("Relation not found.");
        }

        $topic = "/room/{$uuid}";
        $response = [
            'type' => 'request_toggle_media',
            'profile_id' => $profile_id,
            'video' => $video,
            'audio' => $audio,
            'profile_image' => $roomMember->getUserProfile()->one()->image,
        ];

        Yii::$app->mqtt->sendMessage($topic, $response);

        return Json::encode($uuid);
    }
}
