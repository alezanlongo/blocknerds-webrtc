<?php

namespace common\components;

use Yii;
use Ramsey\Uuid\Uuid;
use yii\base\Component;
use yii\httpclient\Client;
use yii\httpclient\Response;
use yii\httpclient\Exception;
use yii\base\InvalidConfigException;
use phpDocumentor\Reflection\Types\Boolean;
use common\components\janusApi\JanusCommonException;
use common\models\JanusAmqpMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecordInterface;
use yii\db\StaleObjectException;
use yii\db\Exception as DbException;
use yii\helpers\VarDumper;
use yii\httpclient\Exception as HttpClientException;

class JanusAmqpComponent extends Component
{
    public $url;
    public $uri;
    public $apiSecret;
    public $adminSecret;
    public $adminUri;
    public $adminKey;
    public $tokenAuthSecret;
    public $storedAuth;
    public $record;
    public $port;
    public $adminPort;

    protected $baseUrl;
    protected $adminBaseUrl;

    private $apiParams;
    private $sessionID = null;
    private $handleID = null;
    public $adminToken = null;
    private $pluginAttached = null;
    private $lastError = null;
    private $adminTokenPrefix = 'adminToken';

    private $amqpConnection = null;

    public const SOURCE_AUDIO = 'audio';
    public const SOURCE_VIDEO = 'video';


    //    public function __construct($config = [])
    //    {
    //        $this->apiParams = $config;
    //        $this->apiParams['baseUrl'] = ($config['url'] ?? '') . ':' . ($config['port'] ?? '') . '/' . $config['uri'] ?? '';
    //        $this->apiParams['adminBaseUrl'] = ($config['url'] ?? '') . ':' . ($config['adminPort'] ?? '') . '/' . $config['adminUri'] ?? '';
    //    }

    public function init()
    {
        parent::init();
        $this->amqpConnection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest', '/');
        $channel = $this->amqpConnection->channel();
        $channel->exchange_declare('janus-exchange', 'direct', false, false, false);
        $channel->queue_declare('to-janus', false, false, false, false);
        $channel->queue_declare('from-janus', false, false, false, false);
        $channel->queue_declare('to-janus-admin', false, false, false, false);
        $channel->queue_declare('from-janus-admin', false, false, false, false);
        $channel->queue_bind('to-janus', 'janus-exchange', 'to-janus');
        $channel->queue_bind('from-janus', 'janus-exchange', 'from-janus');
        $channel->queue_bind('to-janus-admin', 'janus-exchange', 'to-janus-admin');
        $channel->queue_bind('from-janus-admin', 'janus-exchange', 'from-janus-admin');
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

    private function publish(array $message, $admin = false)
    {
        $channel1 = $this->amqpConnection->channel(1);
        $channel2 = $this->amqpConnection->channel(2);
        $msg = new AMQPMessage(\json_encode($message));
        if ($admin === true) {
            $channel1->basic_publish($msg, 'janus-exchange', 'to-janus-admin');
        } else {
            $channel2->basic_publish($msg, 'janus-exchange', 'to-janus');
        }
    }

    public function getMessage($transactionId)
    {
        $cond = ['transaction_id' => $transactionId];
        return JanusAmqpMessage::findOne($cond);
    }

    public function addMessage($transactionId, $actionType, $parentId = null, $referenceId = null, array $attributes = [])
    {
        $mNew = new JanusAmqpMessage();
        $mNew->transaction_id = $transactionId;
        $mNew->action_type = $actionType;
        if (null !== $parentId) {
            $mNew->parent_id = $parentId;
        }
        $mNew->reference_id = $referenceId;
        $mNew->attributes = $attributes;
        $mNew->save(false);
        return $mNew;
    }

    public function updateMessage()
    {
    }

    public function handleJanusMessage($janusMessage)
    {
        $jm = json_decode($janusMessage, true);
        \print_r($jm);
        if (!isset($jm['transaction'])) {
            return false;
        }
        $m = JanusAmqpMessage::findOne(['transaction_id' => $jm['transaction']]);
        if (null !== $m) {
            $this->runHandler($m, $jm);
        }
    }

    private function runHandler(JanusAmqpMessage $message, array $janusMessage, $isRetry = false)
    {
        $handleStatus = false;
        switch ($message->action_type) {
            case JanusAmqpMessage::ACTION_TYPE_GET_ADMIN_TOKEN:
                $handleStatus = $this->handleRequestAdminToken($message, $janusMessage, $isRetry);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_TOKEN:
                $handleStatus = $this->handleStoreToken($message, $janusMessage, $isRetry);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_ROOM:
                $handleStatus = $this->handleVideoRoomCreate($message, $janusMessage, $isRetry);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_SESSION:
                $handleStatus = $this->handleCreateAdminSession($message, $janusMessage, $isRetry);
                break;
            case JanusAmqpMessage::ACTION_TYPE_ATTACH_PLUGIN:
                $handleStatus = $this->handleAttachPlugin($message, $janusMessage, $isRetry);
                break;
        }
        if (true === $handleStatus && null !== $message->parent_id) {
            $parent = $message->getParent()->one();
            echo "callback";
            return $this->runHandler($parent, []);
        }
    }

    public function handleVideoRoomCreate(JanusAmqpMessage $message, array $janusMessage, bool $isRetry)
    {
        \print_r("handle");

        if ($message->status == JanusAmqpMessage::STATUS_COMPLETED) {
            return true;
        }
        if (!empty($janusMessage) && isset($janusMessage['plugindata']['data']['videoroom'])) {
            echo "saveeed 1";
            if ($janusMessage['plugindata']['data']['videoroom'] == 'created') {
                echo "saveeed 2";
                $message->status = JanusAmqpMessage::STATUS_COMPLETED;
                echo "saveeed";
                $message->save(false);
                return true;
            }
            echo "asdas 1";
            return false;
        }
        if (isset($janusMessage['janus']['error'])) {
            $message->status = JanusAmqpMessage::STATUS_FAIL;
            $message->save(false);
            echo "asdas 2";
            return false;
        }

        if ($message->status == JanusAmqpMessage::STATUS_PENDING) {
            $message->status = JanusAmqpMessage::STATUS_PROCESSING;
            $message->save(false);
        }
        $admToken = $this->getAdminToken($message);
        if (null === $admToken) {
            $this->requestAdminToken($message);
            echo "asdas 3";
            return false;
        }
        if (!isset($message->attributes['token'])) {
            $attr = $message->attributes;
            $attr['token'] = $admToken;
            $message->attributes = $attr;
            $message->save(false);
        }
        $sess = $this->getAdminSession($message);
        if (null === $message->session) {
            if (null === $sess) {
                $this->createAdminSession($admToken, $message->id);
                echo "asdas 4";
                return false;
            }
            $message->session = $sess;
            $attr = $message->attributes;
            $attr['session_id'] = $message->session;
            $message->attributes = $attr;
            $message->save(false);
        }

        $ap = $this->getAttachedPlugin($message);
        if (null === $ap) {
            $this->attachPlugin('janus.plugin.videoroom', $message->attributes['token'], $message->session, $message);
            echo "asdas 5";
            return false;
        }

        if (!isset($message->attributes['handle_id'])) {
            $attr = $message->attributes;
            $attr['handle_id'] = $ap['handle_id'];
            $message->attributes = $attr;
            $message->save(false);
        }
        $this->publish($message->attributes);
        return false;
    }

    public function videoRoomCreate(string $uuid, string $description = '')
    {

        $mRes = JanusAmqpMessage::findOne(['reference_id' => $uuid]);
        if (null === $mRes) {
            $tr = $this->createRandStr();
            $m = $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_CREATE_ROOM, null, $uuid, [
                'janus' => 'message',
                'transaction' =>  $tr,
                'session_id' => null,
                'admin_secret' => $this->adminSecret,
                'body' => [
                    'request' => 'create',
                    'room' => $uuid,
                    'description' => $description,
                    'is_private' => true,
                    'publisher' => 10,
                    'admin_key' => $this->adminKey,
                    'record' => Yii::$app->params['janus.record'],
                    'rec_dir' => Yii::$app->params['janus.rec_dir'],
                    'audiocodec' => Yii::$app->params['janus.audiocodec'],
                    'videocodec' => Yii::$app->params['janus.videocodec'],
                ]
            ]);
            $this->handleVideoRoomCreate($m, [], false);
            return;
        }
        $this->runHandler($mRes, []);
    }

    /**
     * 
     * @param string $roomUuid
     * @return Boolean true if room exists, false if not
     */
    public function videoRoomExists(string $roomUuid): bool
    {
        try {
            //$this->attach('janus.plugin.videoroom');
            $res = $this->apiCall(
                'POST',
                [
                    'janus' => 'message',
                    'body' => [
                        'request' => 'exists',
                        'room' => $roomUuid
                    ],
                    'transaction' => $this->createRandStr(),
                    'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()
                ],
                $this->createAdminSession() . '/' . $this->handleID
            );

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
     * Returns an array with all members already connected to an room. If are not members in rooms, return an empty array.
     * @param string $roomUuid uuid of room
     * @return false|array return false if this api call fails
     */
    public function getInRoomMembers(string $roomUuid): false|array
    {
        //$this->attach('janus.plugin.videoroom');
        $res = $this->apiCall(
            'POST',
            [
                'janus' => 'message',
                'body' => [
                    'request' => 'listparticipants',
                    'room' => $roomUuid
                ],
                'transaction' => $this->createRandStr(),
                'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()
            ],
            $this->createAdminSession() . '/' . $this->handleID
        );
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
        //$this->attach('janus.plugin.videoroom');

        //this line aren't right. It's added because something it's wrong in the room access 
        $this->storeToken($token);

        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['action' => 'add', 'request' => 'allowed', 'plugins' => 'janus.plugin.videoroom', 'room' => $roomUuid, 'allowed' => [$token]], 'transaction' => $this->createRandStr(), 'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()], $this->createAdminSession() . '/' . $this->handleID);
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

    public function getMembersTokenByRoom(string $roomUuid): false|array
    {
        //$this->attach('janus.plugin.videoroom');

        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['action' => 'remove', 'request' => 'allowed', 'plugins' => 'janus.plugin.videoroom', 'room' => $roomUuid, 'allowed' => ['fake']], 'transaction' => $this->createRandStr(), 'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()], $this->createAdminSession() . '/' . $this->handleID);
        if (!$res->isOk) {
            return \false;
        }
        $data = $res->getData();
        $res = $this->apiCall('POST', ['janus' => 'list_tokens',  'transaction' => $this->createRandStr(), 'admin_secret' => $this->adminSecret], null, true);
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

    /**
     * Mute and unmute an room member
     * @param string $roomUuid 
     * @param mixed $token member token
     * @param bool $apply true(default) fom mute, false unmute
     * @return bool returns true if the action has completed, false if not 
     */
    public function moderateMember(string $roomUuid, $token, string $source = self::SOURCE_AUDIO, bool $apply = true)
    {

        if (!in_array($source, [self::SOURCE_AUDIO, self::SOURCE_VIDEO])) {
            $this->lastError = "undefined source: $source";
            return false;
        }

        //$this->attach('janus.plugin.videoroom');
        $members = $this->getInRoomMembers($roomUuid);
        if (false === $members) {
            return false;
        }
        if (empty($members)) {
            return false;
        }
        $memberId = $members[\array_search($token, \array_column($members, 'token'))]['id'] ?? null;
        if (null === $memberId) {
            return false;
        }
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['mute_' . $source => $apply, 'request' => 'moderate', 'id' => $memberId, 'room' => $roomUuid], 'transaction' => $this->createRandStr(), 'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()], $this->createAdminSession() . '/' . $this->handleID);

        if (!$res->isOk) {
            return false;
        }
        $data = $res->getData();
        if (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] == 'success') {
            return true;
        }
        $this->lastError = $data['plugindata']['data']['error'] ?? null;
        return false;
    }

    private function getMemberRoomToken(string $roomUuid, string $token): ?string
    {
        $members = $this->getInRoomMembers($roomUuid);
        if (false === $members || empty($members)) {
            return null;
        }

        return $members[\array_search($token, \array_column($members, 'token'))]['id'] ?? null;
    }

    public function kickMember(string $roomUuid, string $token, string $memberId)
    {
        //$this->attach('janus.plugin.videoroom');
        $memberTokenId = $this->getMemberRoomToken($roomUuid, $token);
        if (!$memberTokenId || $memberTokenId !== $memberId) {
            return false;
        }

        $res = $this->apiCall(
            'POST',
            [
                'janus' => 'message',
                'body' => [
                    'request' => 'kick',
                    'id' => $memberId,
                    'room' => $roomUuid
                ],
                'transaction' => $this->createRandStr(),
                'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()
            ],
            $this->createAdminSession() . '/' . $this->handleID
        );

        if (!$res->isOk) {
            return false;
        }

        $data = $res->getData();
        if (isset($data['plugindata']['data']['videoroom']) && $data['plugindata']['data']['videoroom'] == 'success') {
            return true;
        }

        $this->lastError = $data['plugindata']['data']['error'] ?? null;
        return false;
    }

    public function getDataMembers(string $roomUuid)
    {
        //$this->attach('janus.plugin.videoroom');
        $res = $this->apiCall('POST', ['janus' => 'message', 'body' => ['request' => 'listparticipants', 'room' => $roomUuid], 'transaction' => $this->createRandStr(), 'token' => $this->storedAuth ? $this->createAdminToken() : $this->createHmacToken()], $this->createAdminSession() . '/' . $this->handleID);
        if (!$res->isOk) {
            return false;
        }
        $members = $res->getData()['plugindata']['data']['participants'] ?? null;
        // VarDumper::dump( $members, $depth = 10, $highlight = true);
        // die;
        $dataMembers = [];

        if (!empty($members)) {
            foreach ($members as $k => $v) {
                $userHandle = $this->getUserHandle($v['id']);
                $dataMembers[] = [
                    'id' => $userHandle['plugin_specific']['id'],
                    'display' => $userHandle['plugin_specific']['display'],
                    'media' => $userHandle['plugin_specific']['media'],
                ];
            }
        }

        return $dataMembers;
    }


    public function createHmacToken()
    {
        $expire = \floor(\time()) + (12 * 60 * 60);
        $str = join(',', [$expire, 'janus', join(',', ['janus.plugin.videoroom'])]);

        $hmac =  \hash_hmac('sha1', $str, $this->tokenAuthSecret, true);
        return join(':', [$str, \base64_encode($hmac)]);
    }


    private function getSessions()
    {
        $res = $this->apiCall('POST', ['janus' => 'list_sessions', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->adminSecret], null, true);
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
            $resHandle = $this->apiCall('POST', ['janus' => 'list_handles', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->adminSecret], $sess[$i], true);
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

                $handleInfoRes = $this->apiCall('POST', ['janus' => 'handle_info', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->adminSecret], $k . '/' . $v[$i], true);
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

    private function getAdminToken(JanusAmqpMessage $message)
    {
        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_GET_ADMIN_TOKEN, 'status' => JanusAmqpMessage::STATUS_COMPLETED])
            ->limit(1)->one();
        if (null !== $storedMessage) {
            return $storedMessage->attributes[0];
        }
        return null;
    }

    private function requestAdminToken(JanusAmqpMessage $message): int|bool
    {

        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_GET_ADMIN_TOKEN])
            ->andWhere('status!=:status', ['status' => JanusAmqpMessage::STATUS_FAIL]);

        // check expiration


        if ($storedMessage->count() > 0) {
            if ($storedMessage->one()->status === JanusAmqpMessage::STATUS_COMPLETED) {
                return $storedMessage->one()->status;
            }
            if ($storedMessage->one()->attempts <= 100) {
                $storedMessage->one()->increaseAttempt();
                $tr = $storedMessage->one()->transaction_id;
            } else {
                return false;
            }
        } else {
            $tr = $this->createRandStr();
            $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_GET_ADMIN_TOKEN, ($message->isParent() ? $message->id : $message->parent_id));
        }

        $this->publish(['janus' => 'list_tokens', 'transaction' => $tr, 'admin_secret' => $this->adminSecret], true);
        return true;
    }

    private function handleRequestAdminToken(JanusAmqpMessage $message, array $janusMessage, bool $isRetry): bool
    {
        $token = null;
        if (isset($janusMessage['data']) && !empty($janusMessage['data']['tokens'])) {
            $grep = \preg_grep("/^{$this->adminTokenPrefix}.*/", \array_column($janusMessage['data']['tokens'], 'token'));
            if (!empty($grep)) {
                $token =  $grep[\array_key_first($grep)];
            }
        }

        if (isset($janusMessage['janus']) && $janusMessage['janus'] == 'success') {
            if (null !== $token) {
                $message->status = JanusAmqpMessage::STATUS_COMPLETED;
                $message->attributes = [$token];
                $message->save(false);
                return true;
            } else {
                $message->status = JanusAmqpMessage::STATUS_PROCESSING;
                $message->attributes = [false];
                $message->save(false);
                $newToken = $this->adminTokenPrefix . $this->createRandStr(32);
                $this->storeToken($newToken, $message->parent_id);
            }
        }
        return false;
    }

    // private function getStoredTokens()
    // {
    //     $this->publish(['janus' => 'list_tokens', 'transaction' => $this->createRandStr(), 'admin_secret' => $this->adminSecret]);
    // }


    private function storeToken($token, $parentId = null)
    {
        $tr = $this->createRandStr();
        $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_CREATE_TOKEN, $parentId, null, [$token]);
        $this->publish(['janus' => 'add_token', 'token' => $token, 'plugins' => ['janus.plugin.videoroom'], 'transaction' => $tr, 'admin_secret' => $this->adminSecret], true);
    }

    private function handleStoreToken(JanusAmqpMessage $message, array $janusMessage)
    {
        if (isset($janusMessage['janus']) && $janusMessage['janus'] == 'success') {
            $message->status = JanusAmqpMessage::STATUS_COMPLETED;
            $message->save(false);
            return true;
        }
        if ($janusMessage['janus'] == 'error') {
            $message->status = JanusAmqpMessage::STATUS_FAIL;
            $message->save(false);
        }
        return false;
    }

    private function createAdminToken($parentId = null)
    {

        // $this->getMessage();
        //$this->addMessage($uuid, JanusAmqpMessage::ACTION_TYPE_CREATE_SESSION, false);
        $newToken = $this->adminTokenPrefix . $this->createRandStr(32);
        if ($this->storeToken($newToken) === true) {
            return true;
        }
        return false;
    }

    private function handleAttachPlugin(JanusAmqpMessage $message, array $janusMessage, bool $isRetry)
    {
        if (isset($janusMessage['data']['id'])) {
            $attr['plugin']  = $message->attributes;
            $attr['handle_id'] = $janusMessage['data']['id'];
            $message->attributes = $attr;
            $message->status = JanusAmqpMessage::STATUS_COMPLETED;
            $message->save(false);
            return true;
        }
        return false;
    }

    private function getAttachedPlugin(JanusAmqpMessage $message)
    {
        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_ATTACH_PLUGIN, 'status' => JanusAmqpMessage::STATUS_COMPLETED])
            ->limit(1)->one();
        if (null !== $storedMessage) {
            return $storedMessage->attributes;
        }
        return null;
    }

    private function attachPlugin($plugin, $token, $session, JanusAmqpMessage $message)
    {
        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_ATTACH_PLUGIN])
            ->andWhere('status!=:status', ['status' => JanusAmqpMessage::STATUS_FAIL]);

        // check expiration

        if ($storedMessage->count() > 0) {
            return $storedMessage->one()->status;
        }

        $tr = $this->createRandStr();
        $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_ATTACH_PLUGIN, ($message->isParent() ? $message->id : $message->parent_id), null, [$plugin]);
        $this->publish(["janus" => "attach", "plugin" => "janus.plugin.videoroom", "transaction" => $tr, "token" => $token, "session_id" => $session]);
        return null;
    }

    private function getAdminSession(JanusAmqpMessage $message)
    {
        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_CREATE_SESSION])
            ->andWhere('status!=:status', ['status' => JanusAmqpMessage::STATUS_FAIL]);

        // check expiration

        if ($storedMessage->count() > 0) {
            return $storedMessage->one()->session;
        }
        return null;
    }

    /**
     * 
     * @param string $adminToken 
     * @param int|null $parentId 
     * @return true 
     */
    private function createAdminSession(string $adminToken, int $parentId)
    {

        $sess = JanusAmqpMessage::findOne(['parent_id' => $parentId, 'action_type' => JanusAmqpMessage::ACTION_TYPE_CREATE_SESSION]);

        if (null !== $sess) {
            return $sess->status;
        }

        $tr = $this->createRandStr();
        $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_CREATE_SESSION, $parentId, null, ['token' => $adminToken]);
        $this->publish(['janus' => 'create', 'transaction' => $tr, 'admin_secret' => $this->adminSecret, 'token' => $adminToken]);
        return true;
    }

    private function handleCreateAdminSession(JanusAmqpMessage $message, array $janusMessage, bool $isRetry): bool
    {
        if (isset($janusMessage['janus']) && $janusMessage['janus'] == 'error') {
            $message->status = JanusAmqpMessage::STATUS_FAIL;
            $message->save(false);
            return false;
        }

        if (isset($janusMessage['data']['id']) && $janusMessage['janus'] == 'success') {
            $message->attributes = $janusMessage['data']['id'];
            $message->status = JanusAmqpMessage::STATUS_COMPLETED;
            $message->session = $janusMessage['data']['id'];
            $message->save(false);
            return true;
        }

        $message->status = JanusAmqpMessage::STATUS_FAIL;
        $message->save(false);
        return false;
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
            'baseUrl' => ($isAdmin === true ? $this->adminBaseUrl : $this->baseUrl) . ($uri !== null ? '/' . $uri : null)
        ]);
    }

    private function exceptionFormatter($message, Exception $e)
    {
        return $message . ' - ' . $e->getFile() . ':' . $e->getLine();
    }
}
