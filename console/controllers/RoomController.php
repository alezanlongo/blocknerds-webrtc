<?php

namespace console\controllers;

use common\components\janusApi\JanusCommonException;
use common\components\JanusApiComponent;
use common\models\Meeting;
use common\models\Room;
use common\models\RoomMember;
use common\models\RoomMemberRepository;
use common\models\RoomRequest;
use console\components\JanusEventLoggerComponent;
use swoole\foundation\web\Request;
use swoole\foundation\web\Server;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\conditions\BetweenCondition;
use yii\helpers\VarDumper;

class RoomController extends Controller
{
    private $debug = true;

    public function actionEventListener()
    {
        $server = new \Swoole\Http\Server('localhost', 9501, SWOOLE_PROCESS, \SWOOLE_SOCK_TCP);
        $server->set([
            'daemonize' => false,
            'pid_file' => __DIR__ . '/../runtime/server.pid',
            'reactor_num' => 2,
            'worker_num' => 5,
            'log_level' => 0
        ]);
        $server->on('start', function ($server) {
            // printf("listen on %s:%d\n", $server->host, $server->port);
        });
        $server->on('receive', function (\Swoole\Server $server, $fd, $from_id, $data) {
            $server->close($fd);
        });
        $server->on("WorkerStart", function ($server, $workerId) {
            //echo "$workerId\n";
        });

        // Triggered when the HTTP Server starts, connections are accepted after this callback is executed
        $server->on("Start", function ($server, $workerId) {
            // \printf("Swoole server running on: %s port: %d",$server->host,$server->port);
        });

        // The main HTTP server request callback event, entry point for all incoming HTTP requests
        $server->on('Request', function (\Swoole\Http\Request $request, \Swoole\Http\Response $response) {

            $c = $request->getContent();
            /** @var JanusEventLoggerComponent $je */
            $je = \yii::$app->janusEvents;
            $je->pushEvent(json_decode($c, true));
        });

        // Triggered when the server is shutting down
        $server->on("Shutdown", function ($server, $workerId) {
        });

        // Triggered when worker processes are being stopped
        $server->on("WorkerStop", function ($server, $workerId) {
        });
        $server->start();
    }

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
                    continue;
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
                $rr = RoomRequest::find()->where(['user_profile_id' => $m->user_profile_id, 'room_id' => $m->room_id])->limit(1)->one();
                if (!$rr) {
                    $rr = new RoomRequest();
                    $rr->user_profile_id = $m->user_profile_id;
                    $rr->room_id = $m->room_id;
                    $rr->attempts = 1;
                    $rr->status = RoomRequest::STATUS_ALLOW;
                    $rr->save(false);
                }
            }
        }
    }
}
