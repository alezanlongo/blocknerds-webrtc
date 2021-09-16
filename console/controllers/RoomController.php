<?php

namespace console\controllers;

use common\components\janusApi\JanusCommonException;
use common\components\JanusApiComponent;
use common\models\Meeting;
use common\models\Room;
use common\models\RoomMember;
use common\models\RoomMemberRepository;
use common\models\RoomRequest;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\conditions\BetweenCondition;

class RoomController extends Controller
{
    private $debug = true;
    public function actionCreateMeetingRooms()
    {
        $rooms = Room::find()->select(['id', 'uuid', 'status'])
            ->where(
                [
                    'meeting_id' => Meeting::find()->select(['id'])->where(new BetweenCondition('scheduled_at', 'BETWEEN', (time() - (5 * 60)), (time() + (5 * 60)))),
                    'is_quick' => false,
                    'status' => Room::STATUS_PENDING

                ]
            )
            ->all();
        if (empty($rooms)) {
            $this->stdout("nothing to do \n");
            return ExitCode::OK;
        }
        /** @var JanusApiComponent $janus */
        $janus = Yii::$app->janusApi;
        $roomExists = false;
        foreach ($rooms as $r) {
            try {
                $roomExists = $janus->videoRoomExists($r->uuid);
            } catch (JanusCommonException $e) {
                //log err
                return $this->stderr($e->getMessage());
            }
            if (true === $roomExists) {
                if ($this->debug) {
                    $this->stdout('already exists - ' . __METHOD__ . ':' . __LINE__);
                }
                $this->addRoomMembers($r->uuid);
                $r->status = Room::STATUS_CREATED;
                $r->update();
                continue;
            }
            try {
                $roomCreated = $janus->videoRoomCreate($r->uuid);
                if (!$roomCreated) {
                    //log err
                    if ($this->debug) {
                        $this->stdout('room creation fails (' . $r->uuid . ') - ' . __METHOD__ . ':' . __LINE__);
                    }
                }
                $this->addRoomMembers($r->uuid);
            } catch (JanusCommonException $e) {
                //log err
                return $this->stderr($e->getMessage());
            }
        }
    }

    private function addRoomMembers(string $roomUuid)
    {
        $members = RoomMemberRepository::getMembersByRoom($roomUuid);
        $owner = RoomMemberRepository::getOwnerByRoom($roomUuid);
        /** @var JanusApiComponent $janus */
        $janus = Yii::$app->janusApi;
        /** @var RoomMember $m */
        $uTokens = $janus->getMembersTokenByRoom($roomUuid);
        foreach ($members as $m) {
            if (false !== $uTokens && !\in_array($m->token, \array_column($uTokens, 'token'))) {
                $janus->addUserToken($roomUuid, $m->token);
                $rr = new RoomRequest();
                $rr->user_profile_id = $m->user_profile_id;
                $rr->room_id = $m->room_id;
                $rr->status = RoomRequest::STATUS_ALLOW;
                $rr->attempts = 1;
                $rr->save(false);
            }
        }
    }
}
