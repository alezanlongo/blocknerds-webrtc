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
    public $adminToken = null;
    private $pluginAttached = null;
    private $lastError = null;
    private $adminTokenPrefix = 'adminToken';

    public function __construct($config = [])
    {
        $this->apiParams = $config;
        $this->apiParams['baseUrl'] = ($config['url'] ?? '') . ':' . ($config['port'] ?? '') . '/' . $config['uri'] ?? '';
        $this->apiParams['adminBaseUrl'] = ($config['url'] ?? '') . ':' . ($config['adminPort'] ?? '') . '/' . $config['adminUri'] ?? '';
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

    public function videoRoomCreate(string $uuid, string $description = '')
    {
        $this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'create', 'room' => $uuid, 'description' => $description, 'is_private' => true, 'admin_key' => $this->apiParams['adminKey']], 'transaction' =>  $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        if (!$res->isOk) {
        }
        $data = $res->getData();
        if (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] == 'created') {
            return true;
        } elseif (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] != 'created') {
            return false;
        } else {
            $this->lastError = $data['error'];
        }
        return false;
    }

    public function videoRoomExists(string $uuid)
    {
        $this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'exists', 'room' => $uuid], 'transaction' => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        $data = $res->getData();
        if (isset($data['plugindata']['data']['videoroom']) && isset($data['plugindata']['data']['exists']) && $data['plugindata']['data']['videoroom'] == 'success') {
            return $data['plugindata']['data']['exists'];
        }
        return false;
    }

    public function addUserToken($roomUuid, $token)
    {
        $this->attach('janus.plugin.videoroom');
        $this->storeToken($token);

        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['action' => 'add', 'request' => 'allowed', 'plugins' => 'janus.plugin.videoroom', 'room' => $roomUuid, 'allowed' => [$token]], 'transaction' => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        if (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] == 'success') {
            return true;
        } elseif (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] != 'success') {
            return false;
        }
        if (isset($data['error'])) {
            $this->lastError = $data['error'];
        }
        return false;
    }



    public function listUserToken($roomUuid)
    {
        $this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'list_tokens', 'transaction' => $this->createRandStr()], $this->createSession());
        $data = $res->getData();
        \var_dump($data);
    }


    public function createHmacToken()
    {
        $expire = \floor(\time()) + (24 * 60 * 60);
        $str = join(',', [$expire, 'janus', join(',', ['janus.plugin.videoroom'])]);

        $hmac =  \hash_hmac('sha1', $str, $this->apiParams['tokenAuthSecret'], true);
        return join(':', [$str, \base64_encode($hmac)]);
    }

    private function getStoredTokens()
    {
        $res = $this->apiCall('POST', ['janus' => 'list_tokens', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], null, true);
        if (!$res->isOk) {
            return \false;
        }
        $data = $res->getData();
        return !empty($data['data']['tokens']) ? $data['data']['tokens'] : null;
    }

    private function storeToken($token)
    {

        $res = $this->apiCall('POST', ['janus' => 'add_token', 'token' => $token, 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], null, true);
        if (!$res->isOk) {
            return false;
        }
        $data = $res->getData();
        if (isset($data['janus']) && $data['janus'] == 'success') {
            return true;
        }
        return false;
    }

    private function createAdminToken()
    {
        if (null !== $this->adminToken) {
            return $this->adminToken;
        }
        $tokens = $this->getStoredTokens();
        if (false === $tokens) {
            return false;
        }
        if (null !== $tokens) {
            $grep = \preg_grep("/^{$this->adminTokenPrefix}.*/", \array_column($tokens, 'token'));
            if (!empty($grep)) {
                return $this->adminToken = $grep[0];
            }
        }
        $newToken = $this->adminTokenPrefix . $this->createRandStr(32);
        if ($this->storeToken($newToken) === true) {
            return  $this->adminToken = $newToken;
        }
        return false;
    }

    private function attach($plugin)
    {
        $res = $this->apiCall('POST', ["janus" => "attach", 'plugin' => $plugin, "transaction" => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession());
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
        $res = $this->apiCall('POST', ['janus' => 'create', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret'], 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()]);
        if (!$res->isOk /* || $res->isOk && isset($res->getData()['janus']) && $res->getData()['janus'] != 'success' */) {
            return \false;
        }
        if ($forceRefresh === true || !isset($this->sessionID)) {
            $this->sessionID = $res->getData()['data']['id'];
        } elseif (isset($res->getData()['error'])) {
            $this->lastError = $res->getData()['error'];
            return false;
        }
        return $this->sessionID;
    }

    private function apiCall(string $type, $params = [], $uri = null, $isAdmin = false)
    {
        try {
            return match ($type) {
                'POST' => $this->getHttpClient($uri, $isAdmin)->post(null, $params)->setFormat(Client::FORMAT_JSON)->send(),
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
    private function getHttpClient($uri = null, $isAdmin = null): Client
    {
        return \Yii::createObject([
            'class' => Client::class,
            'baseUrl' => ($isAdmin === true ? $this->apiParams['adminBaseUrl'] : $this->apiParams['baseUrl']) . ($uri !== null ? '/' . $uri : null)
        ]);
    }
}
