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
use common\models\JanusAmqpAdmin;
use common\models\JanusAmqpMessage;
use Exception as GlobalException;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use yii\db\ActiveRecordInterface;
use yii\db\conditions\BetweenCondition;
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
        $msg = new AMQPMessage(\json_encode($message));
        if ($admin === true) {
            $channel1 = $this->amqpConnection->channel(1);
            $channel1->basic_publish($msg, 'janus-exchange', 'to-janus-admin');
        } else {
            $channel2 = $this->amqpConnection->channel(2);
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

    private function runHandler(JanusAmqpMessage $message, array $janusMessage = [])
    {
        $handleStatus = false;
        switch ($message->action_type) {
            case JanusAmqpMessage::ACTION_TYPE_REQUEST_ADMIN_TOKEN:
                $handleStatus = $this->handleRequestAdminToken($message, $janusMessage);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_TOKEN:
                $handleStatus = $this->handleStoreToken($message, $janusMessage);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_ROOM:
                $handleStatus = $this->handleVideoRoomCreate($message, $janusMessage);
                break;
            case JanusAmqpMessage::ACTION_TYPE_CREATE_ADMIN_SESSION:
                $handleStatus = $this->handleCreateAdminSession($message, $janusMessage);
                break;
            case JanusAmqpMessage::ACTION_TYPE_REFRESH_ADMIN_SESSION:
                $handleStatus = $this->handleRefreshAdminSession($message, $janusMessage);
                break;
            case JanusAmqpMessage::ACTION_TYPE_ATTACH_PLUGIN:
                $handleStatus = $this->handleAttachPlugin($message, $janusMessage);
                break;
        }
        if (true === $handleStatus && null !== $message->parent_id) {
            $parent = $message->getParent()->one();
            echo "self call";
            return $this->runHandler($parent, []);
        }
    }

    public function handleVideoRoomCreate(JanusAmqpMessage $message, array $janusMessage)
    {
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
        $sess = $this->getAdminSession();
        if (null === $sess) {
            $sess = $this->createAdminSession($admToken, $message);
            return false;
        }
        if (null === $message->session) {
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

    private function getAdminToken(): string|null
    {
        $tkn = JanusAmqpAdmin::getActiveAdminToken();
        if (null === $tkn) {
            return null;
        }
        return $tkn->one()->value;
    }

    private function requestAdminToken(?JanusAmqpMessage $callback = null): bool
    {


        $admTknMessage = JanusAmqpMessage::findOne(['action_type' => JanusAmqpMessage::ACTION_TYPE_REQUEST_ADMIN_TOKEN, 'status' => [JanusAmqpMessage::STATUS_PENDING, JanusAmqpMessage::STATUS_PROCESSING]]);
        if (null !== $admTknMessage) {
            if ($callback) {
                return $this->_createCallback($admTknMessage, $callback);
            }
        }

        $tr = $this->createRandStr();
        $nMsg = $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_REQUEST_ADMIN_TOKEN, null, null);
        if ($callback) {
            $this->_createCallback($nMsg, $callback);
        }
        $this->publish(['janus' => 'list_tokens', 'transaction' => $tr, 'admin_secret' => $this->adminSecret], true);
        return true;
    }

    private function _retryRequestAdminToken(JanusAmqpMessage $message)
    {
        if ($message->status != JanusAmqpMessage::STATUS_PROCESSING) {
            return false;
        }
        $this->publish(['janus' => 'list_tokens', 'transaction' => $message->transaction_id, 'admin_secret' => $this->adminSecret], true);
    }

    private function handleRequestAdminToken(JanusAmqpMessage $message, array $janusMessage): bool
    {

        if (empty($janusMessage)) {
            $this->_retryRequestAdminToken($message);
            return true;
        }

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
                JanusAmqpAdmin::addAdminToken($token);
                $this->_processCallback($message);
                return true;
            } else {
                $message->status = JanusAmqpMessage::STATUS_PROCESSING;
                $message->attributes = [false];
                $message->save(false);
                $newToken = $this->adminTokenPrefix . $this->createRandStr(32);
                $this->storeToken($newToken, $message->id);
            }
        }
        return false;
    }


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

    private function handleAttachPlugin(JanusAmqpMessage $message, array $janusMessage)
    {
        if (isset($janusMessage['data']['id'])) {
            $attr['plugin']  = $message->attributes;
            $attr['handle_id'] = $janusMessage['data']['id'];
            $message->reference_id = $janusMessage['data']['id'];
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

    private function getAdminSession(): ?int
    {
        $sess = JanusAmqpAdmin::getActiveAdminSession();
        if (null !== $sess) {
            return \intval($sess->one()->value);
        }
        return null;
    }

    private function _createCallback(JanusAmqpMessage $parentMessage, $requesterMessage)
    {
        $storedMessage = JanusAmqpMessage::findOne(['parent_id' => $parentMessage->id, 'reference_id' => $requesterMessage->id, 'action_type' => JanusAmqpMessage::ACTION_TYPE_CALLBACK, 'status' => JanusAmqpMessage::STATUS_PENDING]);
        if (null !== $storedMessage) {
            return false;
        }
        $tr = $this->createRandStr();
        $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_CALLBACK, $parentMessage->id, $requesterMessage->id, ['requester_action_type' => $requesterMessage->action_type]);
        return true;
    }

    private function _processCallback(JanusAmqpMessage $message)
    {
        $storedMessage = ($message->isParent() ? $message->getChildren() : $message->find())
            ->where(['parent_id' => ($message->isParent() ? $message->id : $message->parent_id), 'action_type' => JanusAmqpMessage::ACTION_TYPE_CALLBACK, 'status' => JanusAmqpMessage::STATUS_PENDING]);
        if ($storedMessage->count() == 0) {
            return;
        }
        /** @var JanusAmqpMessage $v */
        foreach ($storedMessage->all() as $v) {
            $v->status = JanusAmqpMessage::STATUS_COMPLETED;
            $v->save(false);
            $msg = JanusAmqpMessage::findOne(['id' => $v->reference_id, 'action_type' => JanusAmqpMessage::ACTION_TYPE_CALLBACK]);
            if (null === $msg) {
                continue;
            }
            try {
                $this->runHandler($msg, []);
            } catch (GlobalException $e) {
            }
        }
    }



    public function refreshAdminSession()
    {
        $sess = $this->getAdminSession();
        if (null === $sess) {
            return false;
        }
        $tkn = $this->getAdminToken();
        if (null === $tkn) {
            $this->requestAdminToken();
            return false;
        }
        $storedMessage = JanusAmqpMessage::findOne(['action_type' => JanusAmqpMessage::ACTION_TYPE_REFRESH_ADMIN_SESSION, 'status' => JanusAmqpMessage::STATUS_PENDING]);
        if (null !== $storedMessage) {
            return false;
        }

        $tr = $this->createRandStr();
        $message = $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_REFRESH_ADMIN_SESSION, null, $sess);
        $this->publish(['janus' => 'keepalive', 'transaction' => $tr, 'session_id' => $sess, 'admin_secret' => $this->adminSecret, 'token' => $tkn]);
    }

    private function handleRefreshAdminSession(JanusAmqpMessage $message, array $janusMessage)
    {
        if (isset($janusMessage['janus']) && $janusMessage['janus'] == 'ack') {
            $message->status = JanusAmqpMessage::STATUS_COMPLETED;
            $message->save(false);
            JanusAmqpAdmin::sessionRefreshCount();
            return true;
        }
        $message->status = JanusAmqpMessage::STATUS_FAIL;
        $message->save(false);
        return false;
    }

    /**
     * when int is returned, it is createSession parent message  
     * @param string $adminToken 
     * @return JanusAmqpAdmin|bool 
     */
    private function createAdminSession(string $adminToken, ?JanusAmqpMessage $callback = null): int|bool
    {

        $admSess = $this->getAdminSession();

        if (null !== $admSess) {
            return $admSess;
        }
        $admSessMsg = JanusAmqpMessage::findOne(['action_type' => JanusAmqpMessage::ACTION_TYPE_CREATE_ADMIN_SESSION, 'status' => [JanusAmqpMessage::STATUS_PENDING, JanusAmqpMessage::STATUS_PROCESSING]]);
        if (null !== $admSessMsg) {
            if ($callback) {
                return $this->_createCallback($admSessMsg, $callback);
            }
        }

        $tr = $this->createRandStr();
        $nMsg = $this->addMessage($tr, JanusAmqpMessage::ACTION_TYPE_CREATE_ADMIN_SESSION, null, null, ['token' => $adminToken]);
        $this->publish(['janus' => 'create', 'transaction' => $tr, 'admin_secret' => $this->adminSecret, 'token' => $adminToken]);
        if ($callback) {
            return $this->_createCallback($nMsg, $callback);
        }
        return true;
    }


    private function handleCreateAdminSession(JanusAmqpMessage $message, array $janusMessage): bool
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
            $admSess = JanusAmqpAdmin::addAdminSession($message->session);
            if (true === $admSess) {
                $this->_processCallback($message);
            }
            return true;
        }

        $message->status = JanusAmqpMessage::STATUS_FAIL;
        $message->save(false);
        return false;
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


    private function exceptionFormatter($message, Exception $e)
    {
        return $message . ' - ' . $e->getFile() . ':' . $e->getLine();
    }
}
