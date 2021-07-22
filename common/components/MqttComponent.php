<?php

namespace common\components;

use PhpMqtt\Client\MqttClient;
use yii\base\Component;

/**
 * Description of MqttComponent
 *
 * @author Alejandro Zanlongo <azanlongo at gmail.com>
 */
class MqttComponent extends Component
{

    public $host;
    public $port;

    public function __construct($config = []) {
        $this->host = $config['host'] ?? 'rabbitmq';
        $this->port = $config['port'] ?? 1883;
        parent::__construct($config);
    }

    public function sendMessage(string $topic, array $message, string $clientId = 'mqtt-server') {
        $mqtt = new MqttClient($this->host, $this->port, $clientId);
        $mqtt->connect(null, true);
        $mqtt->publish($topic, json_encode($message));
        $mqtt->disconnect();
    }

}
