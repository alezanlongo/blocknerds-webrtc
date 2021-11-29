<?php

namespace console\controllers;

use common\components\JanusAmqpComponent;
use common\components\janusApi\JanusCommonException;
use common\components\JanusApiComponent;
use common\models\Meeting;
use common\models\Room;
use common\models\RoomMember;
use common\models\RoomMemberRepository;
use common\models\RoomRequest;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Yii;
use yii\console\Controller;
use yii\console\ExitCode;
use yii\db\conditions\BetweenCondition;
use yii\helpers\VarDumper;

class RoomController extends Controller
{
    private $debug = true;

    public function actionEventListener($admin = false)
    {
        /** @var JanusAmqpComponent $janus */
        $janus = Yii::$app->janusAmqp;


        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');


        $channel1 = $connection->channel(1);
        $channel2 = $connection->channel(2);

        $callback = function (AMQPMessage $msg) use ($janus) {
            //echo ' [x] Received r', $msg->body, "\n";
            $janus->handleJanusMessage($msg->body);
        };

        if (!$admin) {
            echo "client";
            $channel2->basic_consume('from-janus', '', false, true, false, false, $callback);
            while ($channel2->is_consuming()) {
                $channel2->wait();
            }
        } else {
            echo "admin";
            $channel1->basic_consume('from-janus-admin', '', false, true, false, false, $callback);
            while ($channel1->is_consuming()) {
                $channel1->wait();
            }
        }
        // $ch = $connection->channel();
        // $ch->basic_consume('to-janus-admin','fanout',true,false,false,function($msg){
        //    echo "asdas";
        // });
        // while($ch->is_consuming()){
        //     echo "wa";
        //     $ch->wait();
        // }
        // $ch->close();
        // $connection->close();


        // $server = new \Swoole\Http\Server('localhost', 9501, SWOOLE_PROCESS, \SWOOLE_SOCK_TCP);
    }

    public function actionSwoole()
    {
        $refreshTime = 50;
        $sessionId = null;
        $lastRefresh = null;

        $server = new \Swoole\Server('localhost', 9501);
        $server->set([
            'daemonize' => false,
            'pid_file' => __DIR__ . '/../runtime/server.pid',
            'reactor_num' => 2,
            'worker_num' => 5,
            'log_level' => 0
        ]);
        $server->on('start', function (\Swoole\Server $server) {
            //$server->task([]);

        });
        $server->on('receive', function (\Swoole\Server $server, $fd, $from_id, $data) {

            //$server->close($fd);
        });
        $server->on("WorkerStart", function ($server, $workerId) {
            // echo "work start";
            // \go(function () {

            //     $connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
            //     $ch = $connection->channel();
            //     $ch->basic_consume('from-janus', 'from-janus-admin', true, false, false, function ($msg) {
            //         \yii\helpers\VarDumper::dump($msg);
            //     });
            //     while ($ch->is_consuming()) {
            //         $ch->wait();
            //     }
            //     echo "aca2";
            //     $ch->close();
            //     $connection->close();
            //     // printf("listen on %s:%d\n", $server->host, $server->port);
            // });

            //echo "$workerId\n";
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
            echo "shutdown";
        });

        // Triggered when worker processes are being stopped
        $server->on("WorkerStop", function ($server, $workerId) {
        });
        /** @var JanusAmqpComponent $janus */
        $janus = \Yii::$app->janusAmqp;
        \Swoole\Timer::tick(30000, function ($tid) use ($janus) {
            $janus->refreshAdminSession();
        }, [$refreshTime]);
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
