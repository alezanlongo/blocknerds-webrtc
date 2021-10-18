<?php

namespace console\components;

use common\models\JanusConnections;
use common\models\JanusCore;
use common\models\JanusDtls;
use common\models\JanusHandles;
use common\models\JanusIce;
use common\models\JanusMedia;
use common\models\JanusPlugins;
use common\models\JanusSdps;
use common\models\JanusSelectedpairs;
use common\models\JanusSessions;
use common\models\JanusStats;
use common\models\JanusTransports;
use yii\base\Component;

class JanusEventLoggerComponent extends Component
{
    public function init()
    {
    }

    public function pushEvent(array $event)
    {
        if (!isset($event['type']) && \is_array($event)) {
            foreach ($event as $e) {
                $this->pushEvent($e);
            }
        }
        $event['type'] = \intval($event['type']);
        switch ($event['type']) {
            case 1:
                $jSess = new JanusSessions();
                $jSess->session = intval($event["session_id"]) ?? 0;
                $jSess->event = $event["event"]["name"] ?? '';
                $jSess->event_timestamp = date('U', $event["timestamp"] / 1000000);
                $jSess->save(false);
                break;
            case 2:
                $ts = date('U', $event["timestamp"] / 1000000);
                $jHand = new JanusHandles();
                $jHand->session = $event["session_id"];
                $jHand->handle = $event["handle_id"];
                $jHand->event = $event["event"]["name"];
                $jHand->plugin = $event["event"]["plugin"];
                $jHand->save(false);
                break;
            case 8:
                $ts = date('U', $event["timestamp"] / 1000000);
                $jSdps = new JanusSdps();
                $jSdps->session = $event["session_id"];
                $jSdps->handle = $event["handle_id"];
                $jSdps->remote = $event["event"]["owner"] == "remote";
                $jSdps->off = $event["event"]["jsep"]["type"] == "offer";
                $jSdps->sdp = \substr($event["event"]["jsep"]["sdp"], 0, 3000);
                $jSdps->save(false);
                break;
            case 16:
                $sessionId = $event["session_id"];
                $handleId = $event["handle_id"];
                $streamId = $event["event"]["stream_id"];
                $componentId = $event["event"]["component_id"];
                $ts = date('U', $event["timestamp"] / 1000000);
                if (isset($event["event"]["ice"])) {
                    // ICE state event
                    $jIce = new JanusIce();
                    $jIce->session =  $sessionId;
                    $jIce->handle = $handleId;
                    $jIce->stream = $streamId;
                    $jIce->component = $componentId;
                    $jIce->state = $event["event"]["ice"];
                    $jIce->save(false);
                } elseif (isset($event["event"]["selected-pair"])) {
                    // ICE selected-pair event
                    $jSelp = new JanusSelectedpairs();
                    $jSelp->session =  $sessionId;
                    $jSelp->handle = $handleId;
                    $jSelp->stream = $streamId;
                    $jSelp->component = $componentId;
                    $jSelp->selected = $event["event"]["selected-pair"];
                    $jSelp->save(false);
                } elseif (isset($event["event"]["dtls"])) {
                    // DTLS state event
                    $jDtls = new JanusDtls();
                    $jDtls->session =  $sessionId;
                    $jDtls->handle = $handleId;
                    $jDtls->stream = $streamId;
                    $jDtls->component = $componentId;
                    $jDtls->state = $event["event"]["dtls"];
                    $jDtls->save(false);
                } elseif ($event["event"]["connection"]) {
                    // Connection (up/down) event
                    $jConn = new JanusConnections();
                    $jConn->session =  $sessionId;
                    $jConn->handle = $handleId;
                    $jConn->stream = $streamId;
                    $jConn->component = $componentId;
                    $jConn->state = $event["event"]["connection"];
                    $jConn->save(false);
                } else {
                    // console.error("Unsupported WebRTC event?");
                }
                break;

            case 32:
                $sessionId = $event["session_id"];
                $handleId = $event["handle_id"];
                $medium = $event["event"]["media"];
                $ts = date('U', $event["timestamp"] / 1000000);

                if (isset($event["event"]["receiving"]) && $event["event"]["receiving"] != 'null') {
                    // Media receiving state event
                    $jMedia = new JanusMedia();
                    $jMedia->session = $sessionId;
                    $jMedia->handle = $handleId;
                    $jMedia->medium = $medium;
                    $jMedia->receiving = $event["event"]["receiving"] == true;
                    $jMedia->save(false);
                } elseif (isset($event["event"]["base"]) && $event["event"]["base"] !== null) {
                    // Statistics event
                    $jStats = new JanusStats();
                    $jStats->session = $sessionId;
                    $jStats->handle = $handleId;
                    $jStats->medium = $medium;
                    $jStats->base = $event["event"]["base"];
                    $jStats->lsr = $event["event"]["lsr"] ?? '';
                    $jStats->lostlocal = $event["event"]["lost"] ?? '';
                    $jStats->lostremote = $event["event"]["lost-by-remote"] ?? '';
                    $jStats->jitterlocal = $event["event"]["jitter-local"] ?? '';
                    $jStats->jitterremote = $event["event"]["jitter-remote"] ?? '';
                    $jStats->packetssent = $event["event"]["packets-sent"] ?? '';
                    $jStats->packetsrecv = $event["event"]["packets-received"] ?? '';
                    $jStats->bytessent = $event["event"]["bytes-sent"] ?? '';
                    $jStats->bytesrecv = $event["event"]["bytes-received"] ?? '';
                    $jStats->nackssent = $event["event"]["nacks-sent"] ?? '';
                    $jStats->nacksrecv = $event["event"]["nacks-received"] ?? '';
                    $jStats->save(false);
                } else {
                    // console.error("Unsupported media event?");
                }
                break;
            case 64:
            case 128:
                $sessionId = $event["session_id"] ?? '';
                $handleId = $event["handle_id"] ?? '';
                $plugin = $event["event"]["plugin"] ?? '';
                $evData = \serialize($event["event"]["data"] ?? []);
                $ts = date('U', $event["timestamp"] / 1000000);
                /** @var JanusTransports $tableClass */
                if ($event['type'] == 64) {
                    $tableClass  = new JanusPlugins();
                } else {
                    $tableClass  = new JanusTransports();
                }
                $tableClass->session = $sessionId;
                $tableClass->handle = $handleId;
                $tableClass->plugin = $plugin;
                $tableClass->event = $evData;
                $tableClass->save(false);
                break;
            case 256:
                // Core event
                $name = "status";
                $evValue = $event["event"]['name'];
                $signum = $event["event"]["signum"]??null;
                if ($signum) {
                    $evValue += " (" + $signum + ")";
                }
                $ts = date('U', $event["timestamp"] / 1000000);
                $jCore = new JanusCore();
                $jCore->name = "status";
                $jCore->value = $evValue;
                $jCore->save(false);
        }
    }
}
