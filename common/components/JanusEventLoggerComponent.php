<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\JanusEvents;

class JanusEventLoggerComponent extends Component
{
    public function init()
    {
    }

    public function pushEvent($event)
    {
        // Yii::warning('***NAHUEL EVENT****', var_export($event, true));

        if (!isset($event['type']) && is_array($event)) {
            foreach ($event as $e) {
                $this->pushEvent($e);
            }
        }

        if (isset($event['type'])) {
            $event['type'] = intval($event['type']);
        } else {
            return false;
        }

        $janusEvent = new JanusEvents();
        $janusEvent->type = $event['type'];
        $janusEvent->session = isset($event["session_id"]) ? intval($event["session_id"]) : null;
        $janusEvent->event = isset($event["event"]["name"]) ? $event["event"]["name"] : null;
        $janusEvent->state = isset($event["event"]) && is_array($event["event"]) && !isset($event["event"]["name"]) ? $event['event'][array_key_first($event['event'])] : null;
        $janusEvent->handle = $event["handle_id"] ?? null;
        $janusEvent->plugin = $event["event"]["plugin"] ?? null;
        $janusEvent->remote = isset($event["event"]["owner"]) ? $event["event"]["owner"] === "remote" : null;
        $janusEvent->off = isset($event["event"]["jsep"]["type"]) ? $event["event"]["jsep"]["type"] === "offer" : null;
        $janusEvent->sdp = isset($event["event"]["jsep"]["sdp"]) ? substr($event["event"]["jsep"]["sdp"], 0, 3000) : null;
        $janusEvent->stream = $event["event"]["stream_id"] ?? null;
        $janusEvent->component = $event["event"]["component_id"] ?? null;
        $janusEvent->selected = $event["event"]["selected-pair"] ?? null;
        $janusEvent->medium = $event["event"]["media"] ?? null;
        $janusEvent->receiving = isset($event["event"]["receiving"]) ? $event["event"]["receiving"] === true : null;
        $janusEvent->base = $event["event"]["base"] ?? null;
        $janusEvent->lsr = $event["event"]["lsr"] ?? null;
        $janusEvent->lostlocal = $event["event"]["lost"] ?? null;
        $janusEvent->lostremote = $event["event"]["lost-by-remote"] ?? null;
        $janusEvent->jitterlocal = $event["event"]["jitter-local"] ?? null;
        $janusEvent->jitterremote = $event["event"]["jitter-remote"] ?? null;
        $janusEvent->packetssent = $event["event"]["packets-sent"] ?? null;
        $janusEvent->packetsrecv = $event["event"]["packets-received"] ?? null;
        $janusEvent->bytessent = $event["event"]["bytes-sent"] ?? null;
        $janusEvent->bytesrecv = $event["event"]["bytes-received"] ?? null;
        $janusEvent->nackssent = $event["event"]["nacks-sent"] ?? null;
        $janusEvent->nacksrecv = $event["event"]["nacks-received"] ?? null;
        $janusEvent->data = isset($event["event"]["data"]) ? serialize($event["event"]["data"]) : null;

        if ($event['type'] == 256) {
            $name = "status";
            $evValue = $event["event"][$name] ?? null;
            $signum = $event["event"]["signum"] ?? null;
            if ($signum) {
                $evValue += " (" + $signum + ")";
            }
            $janusEvent->name = $name;
            $janusEvent->value = $evValue;
        }

        $janusEvent->event_timestamp = date('U', $event["timestamp"] / 1000000);
        $janusEvent->save(false);
    }
}
