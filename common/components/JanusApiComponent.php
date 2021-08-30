<?php

namespace common\components;

use common\components\janusApi\JanusCommonException;
use common\traits\HttpClientTrait;
use Exception as GlobalException;
use phpDocumentor\Reflection\Types\Boolean;
use Ramsey\Uuid\Uuid;
use yii\base\Component;
use yii\base\InvalidConfigException;
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

        try {
            $this->attach('janus.plugin.videoroom');
            $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'create', 'room' => $uuid, 'description' => $description, 'is_private' => true, 'publisher' => 10, 'admin_key' => $this->apiParams['adminKey']], 'transaction' =>  $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        } catch (Exception $e) {
            $this->lastError = $this->exceptionFormatter('janus server not found', $e);
            throw new JanusCommonException($this->lastError, 404);
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

    /**
     * 
     * @param string $roomUuid
     * @return Boolean true if room exists, false if not
     */
    public function videoRoomExists(string $roomUuid): bool
    {
        try {
            $this->attach('janus.plugin.videoroom');
            $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'exists', 'room' => $roomUuid], 'transaction' => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
            $data = $res->getData();
        } catch (Exception $e) {
            $this->lastError = $this->exceptionFormatter('janus server not found', $e);
            throw new JanusCommonException($this->lastError, 404);
        }
        if (isset($data['plugindata']['data']['videoroom']) && isset($data['plugindata']['data']['exists']) && $data['plugindata']['data']['videoroom'] == 'success') {
            return \boolval($data['plugindata']['data']['exists']);
        }
        return false;
    }

    /**
     * Returns an array with all members already connected to an room. If somethings fails, returns false
     * @param string $roomUuid uuid of room
     * @return false|array 
     */
    public function getInRoomUsersToken(string $roomUuid): false|array
    {
        $this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'listparticipants', 'room' => $roomUuid], 'transaction' => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        if (!$res->isOk) {
            return false;
        }
        $data = $res->getData();
        if (!isset($data['janus']) || $data['janus'] !== 'success') {
            //log error
            return false;
        }
        $participants = [];
        if (!empty($data['plugindata']['data']['participants'])) {
            foreach ($data['plugindata']['data']['participants'] as $k => $v) {
                $participants[$k] = ['id' => $v['id']];
                $userHandle = $this->getUserHandle($v['id']);
                if (!empty($userHandle) && isset($userHandle['token'])) {
                    $participants[$k]['token'] = $userHandle['token'];
                }
            }
        }
        return $participants;
    }


    /**
     * Add token to a specific room
     * @param mixed $roomUuid 
     * @param mixed $token 
     * @return bool true or false if an error occurs
     */
    public function addUserToken($roomUuid, $token): bool
    {
        $this->attach('janus.plugin.videoroom');

        //this line aren't right. It's added because something it's wrong in the room access 
        $this->storeToken($token);

        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['action' => 'add', 'request' => 'allowed', 'plugins' => 'janus.plugin.videoroom', 'room' => $roomUuid, 'allowed' => [$token]], 'transaction' => $this->createRandStr(), 'token' => $this->apiParams['storedAuth'] ? $this->createAdminToken() : $this->createHmacToken()], $this->createSession() . '/' . $this->handleID);
        if (!$res->isOk) {
            return \false;
        }
        $data = $res->getData();
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

    public function getUsersTokenByRoom(string $roomUuid): false|array
    {
        $this->attach('janus.plugin.videoroom');

        $res = $this->apiCall('POST', ['janus' => 'list_tokens',  'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], null, true);
        if (!$res->isOk) {
            return \false;
        }
        $data = $res->getData();
        if (isset($data['janus']) && $data['janus'] == 'success') {
            return  $data['data']['tokens'];
        }
        if (isset($data['error'])) {
            $this->lastError = $data['error'];
        }
        return false;
    }


    public function createHmacToken()
    {
        $expire = \floor(\time()) + (12 * 60 * 60);
        $str = join(',', [$expire, 'janus', join(',', ['janus.plugin.videoroom'])]);

        $hmac =  \hash_hmac('sha1', $str, $this->apiParams['tokenAuthSecret'], true);
        return join(':', [$str, \base64_encode($hmac)]);
    }


    private function getSessions()
    {
        $res = $this->apiCall('POST', ['janus' => 'list_sessions', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], null, true);
        if (!$res->isOk) {
            return false;
        }
        if ($res->getData()['janus'] !== 'success') {
            return false;
        }
        return $res->getData()['sessions'];
    }

    private function getUserHandle(string $janusUserId)
    {
        $sess = $this->getSessions();
        if (false === $sess) {
            return false;
        }
        if (empty($sess)) {
            return [];
        }
        for ($i = 0; $i < count($sess); $i++) {
            $resHandle = $this->apiCall('POST', ['janus' => 'list_handles', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], $sess[$i], true);
            if (!$resHandle->isOk || $resHandle->getData()['janus'] !== 'success') {
                return false;
            }
            if (!empty($resHandle->getData()['handles'])) {
                $handles[$sess[$i]] = $resHandle->getData()['handles'];
            }
        }
        if (empty($handles)) {
            return [];
        }
        foreach ($handles as $k => $v) {
            for ($i = 0; $i < count($v); $i++) {

                $handleInfoRes = $this->apiCall('POST', ['janus' => 'handle_info', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], $k . '/' . $v[$i], true);
                if (!$handleInfoRes->isOk || $handleInfoRes->getData()['janus'] !== 'success') {
                    return false;
                }
                if (isset($handleInfoRes->getData()['info']['plugin_specific']['id']) && $handleInfoRes->getData()['info']['plugin_specific']['id'] === $janusUserId) {
                    return $handleInfoRes->getData()['info'];
                }
            }
        }
        return [];
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

        $res = $this->apiCall('POST', ['janus' => 'add_token', 'token' => $token, 'plugins' => ['janus.plugin.videoroom'], 'transaction' => $this->createRandStr(), 'admin_secret' => $this->apiParams['adminSecret']], null, true);
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
                return $this->adminToken =  $grep[\array_key_first($grep)];
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

    /**
     * 
     * @param bool $forceRefresh 
     * @return mixed 
     * @throws Exception 
     * @throws InvalidConfigException 
     */
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

    private function exceptionFormatter($message, Exception $e)
    {
        return $message . ' - ' . $e->getFile() . ':' . $e->getLine();
    }
}
