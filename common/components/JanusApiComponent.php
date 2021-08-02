<?php

namespace common\components;

use common\traits\HttpClientTrait;
use Ramsey\Uuid\Uuid;
use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\Exception;
use yii\httpclient\Exception as HttpClientException;
use yii\httpclient\Response;

class JanusApiComponent extends Component
{

    private $apiParams;
    private $sessionID = null;
    private $handleID = null;
    private $pluginAttached = null;
    private $lastError = null;

    public function __construct($config = [])
    {
        $this->apiParams['baseUrl'] = ($config['url'] ?? '') . ':' . ($config['port'] ?? '') . '/' . $config['uri'] ?? '';
    }

    public function destroy(): void
    {
        $this->sessionID = null;
        $this->handleID = null;
        $this->lastError = null;
        $this->pluginAttached = null;
    }

    public function getLastErrors(): ?array
    {
        return $this->lastError;
    }

    public function videoRoomCreate(int $id, string $description = '')
    {
        $this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'create', 'room' => $id, 'description' => $description, 'is_private' => true], 'transaction' =>  $this->createRandStr()], $this->createSession() . '/' . $this->handleID);
        if (!$res->isOk) {
        }
        $data = $res->getData();
        // var_dump($data);
        if (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] == 'created') {
            return true;
        } elseif (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] != 'created') {
            return false;
        } else {
            $this->lastError = $data['error'];
            return false;
        }
    }

    public function videoRoomExists(string $uuid, $handleId = null)
    {
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'exists', 'room' => $uuid], 'transaction' => $this->createRandStr()], $this->createSession() . '/' . $this->handleID);
        $data = $res->getData();
        // \var_dump($data);
    }

    function attach($plugin)
    {
        $res = $this->apiCall('POST', ["janus" => "attach", 'plugin' => $plugin, "transaction" => $this->createRandStr()], $this->createSession());
        if (!$res->isOk) {
        }
        $data = $res->getData();
        if (isset($data['data']['id'])) {
            $this->pluginAttached = $plugin;
            $this->handleID = $data['data']['id'];
            return $this->handleID;
        }
        $this->pluginAttached = null;
        $this->handleID = null;
        return false;
    }

    private function createSession($forceRefresh = false)
    {
        $res = $this->apiCall('POST', ['janus' => 'create', 'transaction' => $this->createRandStr()]);
        if (!$res->isOk /* || $res->isOk && isset($res->getData()['janus']) && $res->getData()['janus'] != 'success' */) {
            return \false;
        }
        if ($forceRefresh === true || !isset($this->sessionID)) {
            $this->sessionID = $res->getData()['data']['id'];
        }
        return $this->sessionID;
    }

    private function apiCall(string $type, $params = [], $uri = null)
    {
        try {
            return match ($type) {
                'POST' => $this->getHttpClient($uri)->post(null, $params)->setFormat(Client::FORMAT_JSON)->send(),
                default => false
            };
        } catch (HttpClientException $ex) {
            // Log error
            throw new Exception('Internal error ' . $ex->getMessage());
        }
    }


    private function getResponseErrors(Response $res): ?string
    {
        if ($res->getData()['errors']) {
            return join(' / ', $res->getData()['errors']);
        }
        return null;
    }


    private function createRandStr($length = 15)
    {
        $chr = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $chrLength = strlen($chr);
        $randomStr = '';
        for ($i = 0; $i < $length; $i++)
            $randomStr .= $chr[rand(0, $chrLength - 1)];

        return $randomStr;
    }

    /**
     * Get Yii2-httpclient
     * @return Client
     */
    private function getHttpClient($uri = null): Client
    {
        return \Yii::createObject([
            'class' => Client::class,
            'baseUrl' => $this->apiParams['baseUrl'] . ($uri !== null ? '/' . $uri : null)
        ]);
    }
}
