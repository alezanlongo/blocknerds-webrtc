<?php

namespace frontend\controllers;

use Yii;
use DateTime;
use Carbon\Carbon;
use common\components\JanusApiComponent;
use common\models\Chat;
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
use Exception;
use yii\helpers\Url;
use yii\helpers\VarDumper;
use yii\web\Response;
use yii\web\ServerErrorHttpException;
use yii\web\BadRequestHttpException;
use yii\web\ForbiddenHttpException;
use yii\web\UnauthorizedHttpException;

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

    private function addMemberToRoom(string $room, string $token)
    {
        $uTokens = Yii::$app->janusApi->getMembersTokenByRoom($room);
        if (false !== $uTokens && (empty($uTokens) || !\in_array($token, \array_column($uTokens, 'token')))) {
            $res = Yii::$app->janusApi->addUserToken($room, $token);
        }
    }

    public function actionIndex($uuid)
    {
        $this->layout = 'main-room';
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

        // $profileIds = RoomMember::find()
        //     ->where(['room_id' => $room->id])
        //     ->select('user_profile_id');

        // $members = [];
        // foreach ($profileIds->all() as $member) {
        //     if ($member->user_profile_id !== $profile->id) {
        //         $members[] =  [
        //             'id' => $member->user_profile_id,
        //             'user_id' => $member->getUser()->id,
        //             'username' => $member->getUser()->username,
        //         ];
        //     }
        // }

        $members = RoomMemberRepository::getMembersByRoom($room->uuid);

        if (count($members) > $limit_members) {
            var_dump("No possible add more members can't be in this room. The limit is " . $limit_members);
            die;
        }

        $token = null;
        if (($is_owner || $is_allowed) && Yii::$app->janusApi->videoRoomExists($uuid) === true) {
            $userToken = RoomMember::find()->select('token')->where(['user_profile_id' => $profile->id, 'room_id' => $room->id])->limit(1)->one();
            $token = $userToken->token;
            if ($room->is_quick) {
                $uTokens = Yii::$app->janusApi->getMembersTokenByRoom($uuid);
                if (false !== $uTokens && (empty($uTokens) || !\in_array($token, \array_column($uTokens, 'token')))) {
                    $res = Yii::$app->janusApi->addUserToken($uuid, $token);
                }
            }
        } else {
            if (!$room->is_quick) {
                // $filter = ['room_id'=>$room->id, 'user_profile_id' => $profile->id];
                // $roomMember = RoomMember::find()->where($filter)->limit(1)->one();
                // if($roomMember) $roomMember->delete();
                // $roomRequest = RoomRequest::find()->where($filter)->limit(1)->one();
                // if($roomRequest) $roomRequest->delete();
                throw new UnauthorizedHttpException("Private meeting, you don't have access.");
            }
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
        if (!empty($irm)) {
            $sourceStatus = RoomMember::find()->select(['mute_audio', 'mute_video', 'token'])->where(['token' => array_column($irm, 'token')])->asArray()->all();
            \array_walk($irm, function (&$i) use ($sourceStatus) {
                $idx = \array_search($i['token'], array_column($sourceStatus, 'token'));
                if (false !== $idx) {
                    $i['mute_audio'] = $sourceStatus[$idx]['mute_audio'];
                    $i['mute_video'] = $sourceStatus[$idx]['mute_video'];
                }
            });
        }
        // get own source status
        $ownSourceStatus = RoomMember::find()->select(['mute_audio', 'mute_video'])
            ->where(['room_id' => $room->id, 'user_profile_id' => $profile->id])
            ->asArray()->one();

        $meeting = $room->getMeeting()->one();
        $endTime = $meeting->scheduled_at + $meeting->duration;

        $chats = Chat::find()->where(['room_id' => $room->id, 'to_profile_id' => null])->all();
        $roomMembers = RoomMember::find()->where(['user_profile_id' => $profile->id])->orderBy(['created_at' => SORT_DESC])->all();
        $rooms = array_map(function ($roomMember) {
            $room = $roomMember->room;
            return [
                'title' => $room->meeting->title,
                'uuid' => $room->uuid,
                'token' => $roomMember->token,
                'created_at' => Carbon::createFromTimestamp($room->meeting->created_at, $roomMember->userProfile->timezone)->format('Y-m-d H:i:s'),
            ];
        }, $roomMembers);

        return $this->render('index', [
            'dataRooms' => $rooms,
            'user_profile_id' => $profile->id,
            'limit_members' => $limit_members,
            'in_room_members' => $inRoomMembersIds,
            'in_room_members_source_status' => $irm,
            'members' => $members,
            'room_id' => $room->id,
            'is_owner' => $is_owner,
            'is_allowed' => $is_allowed,
            'status' => $status,
            'request' => $request,
            'requests' => $requests,
            'endTime' => $endTime,
            'own_mute_audio' => $ownSourceStatus['mute_audio'] ?? false,
            'own_mute_video' => $ownSourceStatus['mute_video'] ?? false,
            'myChannel' => md5($profile->id),
            'chats' => $chats
        ]);
    }

    public static function getRooms(int $profileId)
    {
        $roomMembers = RoomMember::find()->where(['user_profile_id' => $profileId])->orderBy(['created_at' => SORT_DESC])->all();
        $rooms = array_map(function ($roomMember) {
            $room = $roomMember->room;
            return [
                'title' => $room->meeting->title,
                'name' => $room->uuid,
                'created_at' => Carbon::createFromTimestamp($room->meeting->created_at, $roomMember->userProfile->timezone)->format('Y-m-d H:i:s'),
            ];
        }, $roomMembers);

        return $rooms;
    }

    private function getToken(string $roomUuid, string $profileId): string|null
    {
        $room = Room::findOne(['uuid' => $roomUuid]);
        if (!$room) {
            return null;
        }
        $roomMember = RoomMember::findOne(['room_id' => $room->id, 'user_profile_id' => $profileId]);
        if (!$roomMember) {
            return null;
        }
        return $roomMember->token;
    }

    public function actionSwitchingRoom()
    {
        $janusApi = Yii::$app->janusApi;
        $roomUuidFrom = $this->request->post('from');
        $roomUuidTo = $this->request->post('to');
        $profileId = 1;
        $tokenFrom = $this->getToken($roomUuidFrom, $profileId);
        $tokenTo = $this->getToken($roomUuidTo, $profileId);
        
        if(!$tokenFrom || !$tokenTo){
            throw new UnprocessableEntityHttpException("You can not switching between rooms");
        }

        // $janusApi->removeUserToken($roomUuidFrom,$tokenFrom);
        // $janusApi->addUserToken($roomUuidTo,$tokenTo);

        return "switching room $tokenTo uuid $roomUuidTo";
    }

    private function createMeeting(string $title, int $profileId): Meeting|null
    {
        $meeting = new Meeting();
        $fields['Meeting']['title'] = $title;
        $fields['Meeting']['owner_id'] = $profileId;
        $fields['Meeting']['duration'] = Meeting::DEFAULT_DURATION;
        $fields['Meeting']['scheduled_at'] = time();
        $fields['Meeting']['reminder_time'] = 0;
        $fields['Meeting']['allow_waiting'] = 1;

        try {
            $meeting->load($fields) && $meeting->save();
            return $meeting;
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * 
     * @param string $roomUuid id of the room
     * @param string $profileId userToken into the room
     * @return void httpStatus code 200 if everything was fine, 503 if janus fails
     */
    public function actionModerateMember(string $roomUuid, string $profileId)
    {
        $this->response->format = Response::FORMAT_JSON;
        $arrSources = [JanusApiComponent::SOURCE_AUDIO, JanusApiComponent::SOURCE_VIDEO];

        if (!$this->request->isAjax || !$this->request->isPost) {
            throw new NotFoundHttpException("page not found");
        }
        if (null === $this->request->post('source') || !\in_array($this->request->post('source'), $arrSources)) {
            throw new BadRequestHttpException("invalid source");
        }

        if (null === $this->request->post('mute') || !\in_array($this->request->post('mute'), ['true', 'false', true, false])) {
            throw new BadRequestHttpException('invalid mute');
        }

        $user = Yii::$app->user->identity;
        if (!$user) {
            throw new ForbiddenHttpException();
        }
        $room = Room::find()->where(['uuid' => $roomUuid])->limit(1)->one();
        if (!$room) {
            throw new NotFoundHttpException("Room not found.");
        }

        $meeting = $room->getMeeting()->one();

        if (!$meeting) {
            throw new NotFoundHttpException("Meeting not found.");
        }

        $user = Yii::$app->user->identity;
        $profile = $user->getUserProfile()->one();
        if ($profile->id != $meeting->owner_id) {
            throw new ForbiddenHttpException("Unauthorized request");
        }
        $roomMember = RoomMember::find()->where(['user_profile_id' => $profileId, 'room_id' => $room->id])->limit(1)->one();
        $token = $roomMember->token;

        if (null === $token) {
            throw new ForbiddenHttpException("Unauthorized request");
        }
        $this->response->statusCode = 503;
        $action = \in_array($this->request->post('mute'), ['true', 1]) ? true : false;
        if (Yii::$app->janusApi->moderateMember($roomUuid, $token, $this->request->post('source'), $action)) {
            $this->response->statusCode = 200;
            $curr_moderate_audio = $roomMember->moderate_audio;
            $curr_moderate_video = $roomMember->moderate_video;

            if ($this->request->post('source') == JanusApiComponent::SOURCE_AUDIO) {
                $roomMember->mute_audio = $action;
                $roomMember->moderate_audio = $action;
            } else {
                $roomMember->mute_video = $action;
                $roomMember->moderate_video = $action;
            }
            $roomMember->update(false);
            $this->response->data = ['moderate_audio' => $roomMember->moderate_audio, 'moderate_audio_change' => $curr_moderate_audio !== $roomMember->moderate_audio, 'moderate_video' => $roomMember->moderate_video, 'moderate_video_change' => $curr_moderate_video !== $roomMember->moderate_video];
            $topic = "/room/{$roomUuid}";
            $mqttResponse = [
                'type' => 'moderate_user_source',
                'profile_id' => $profileId,
                'moderate_audio' => $roomMember->moderate_audio,
                'moderate_audio_change' => $curr_moderate_audio !== $roomMember->moderate_audio,
                'moderate_video' => $roomMember->moderate_video,
                'moderate_video_change' => $curr_moderate_video !== $roomMember->moderate_video
            ];

            Yii::$app->mqtt->sendMessage($topic, $mqttResponse);
        }
        return $this->response;
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

            // $isDoctor = $profile->id === 1;
            // if ($isDoctor) {
            //     $meetingDoc  = Meeting::findOne(['title' => Meeting::DEFAULT_DOCTOR_TITLE]);

            //     if (!$meetingDoc) {
            //         $meetingDoc = $this->createMeeting(Meeting::DEFAULT_DOCTOR_TITLE, $profile->id);
            //     }

            //     if (!$meetingDoc) {
            //         throw new UnprocessableEntityHttpException("Meeting not available");
            //     }
            //     $roomDoc = $meetingDoc->room;
            //     if (!$roomDoc) {
            //         $roomDoc = new Room();
            //         $roomDoc->meeting_id = $meetingDoc->id;
            //         $roomDoc->is_quick = true;
            //         $roomDoc->status = Room::STATUS_CREATED;
            //         $roomDoc->save();
            //     }
            //     $memberOwner = RoomMember::findOne(['room_id' => $roomDoc->id, 'user_profile_id' => $profile->id]);
            //     if (!$memberOwner) {
            //         $memberOwner = new RoomMember();
            //         $memberOwner->room_id = $roomDoc->id;
            //         $memberOwner->user_profile_id = $profile->id;
            //         $memberOwner->save();
            //     }

            //     if (!Yii::$app->janusApi->videoRoomExists($roomDoc->uuid)) {
            //         Yii::$app->janusApi->videoRoomCreate($roomDoc->uuid);
            //     }
            //     $this->addMemberToRoom($roomDoc->uuid, $profile->hashId);
            // }

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
                    $userMidnightInUTC = Carbon::tomorrow()->setTimezone($profile->timezone); //->timestamp;
                    if (Carbon::createFromTimestamp($nearestMeeting->scheduled_at)->lessThan($userMidnightInUTC)) {
                        $text = $nearestMeeting->title . ', starts in ' . Carbon::createFromTimestamp($nearestMeeting->scheduled_at)->diffForHumans();

                        $cardNextOrInProgressMeetingWidget = cardNextOrInProgressMeetingWidget::widget([
                            'title' => 'Next meeting',
                            'text' => $text,
                            'url' => Url::to('room/' . $nearestMeeting->room->uuid),
                        ]);
                    }
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
            'initialView' => $initialView ? $initialView->value : 'timeGridWeek',
            'cardNextOrInProgressMeetingWidget' => $cardNextOrInProgressMeetingWidget,
            'myChannel' => md5($profile->id),
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
    public function actionKickMember()
    {
        $profileId = $this->request->post('profileId');
        $roomUuid = $this->request->get('uuid');

        $roomMember = $this->checkMember($roomUuid, $profileId);
        $room = Room::find()->where(['uuid' => $roomUuid])->limit(1)->one();

        if ($room->getOwner()->user_id !== Yii::$app->getUser()->getId()) {
            return throw new ServerErrorHttpException("Only owner of the room is allowed.");
        }

        if (!Yii::$app->janusApi->kickMember($roomUuid, $roomMember->token)) {
            return throw new ServerErrorHttpException("Error kicking member of the room");
        }

        $roomRequest = RoomRequest::find()->where(['room_id' => $room->id, 'user_profile_id' => $profileId])->limit(1)->one();
        $roomRequest->delete();
        $roomMember->delete();

        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'status' => 200
        ];
    }

    public function actionToggleMedia()
    {
        $this->response->format = Response::FORMAT_JSON;
        $uuid = $this->request->post('uuid') ?? null;
        $profile_id = $this->request->post('user_profile_id') ?? null;
        $video = $this->request->post('video') ?? null;
        $audio = $this->request->post('audio') ?? null;

        $roomMember = $this->checkMember($uuid, $profile_id);

        if (null !== $audio && $roomMember->moderate_audio) {
            $this->response->statusCode = 503;
            $this->response->data = "Moderated source";
            return $this->response;
        }

        if (null !== $audio && !$roomMember->moderate_audio) {
            $roomMember->mute_audio = \in_array($audio, ['true', 1]);
            $roomMember->update(false);
        }

        if (null !== $video && $roomMember->moderate_video) {
            $this->response->statusCode = 503;
            $this->response->data = "Moderated source";
            return $this->response;
        }

        if (null !== $video && !$roomMember->moderate_video) {
            $roomMember->mute_video = \in_array($video, ['true', 1]);
            $roomMember->update(false);
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

    private function checkMember(string $roomUuid, string $profileId)
    {
        $room = Room::find()->where(['uuid' => $roomUuid])->limit(1)->one();
        if (!$room) {
            return throw new NotFoundHttpException("Room not found.");
        }

        $profile = UserProfile::find()->where(['id' => $profileId])->limit(1)->one();

        if (!$profile) {
            return throw new NotFoundHttpException("Profile not found.");
        }

        // $profile = UserProfile::findOne(['user_id' => Yii::$app->getUser()->id]);
        $roomMember = RoomMember::find()
            ->where(['user_profile_id' => $profileId, 'room_id' => $room->id])
            ->limit(1)->one();

        if (!$roomMember) {
            return throw new NotFoundHttpException("Relation not found.");
        }

        return $roomMember;
    }
}
