<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\conditions\BetweenCondition;

/**
 * This is the model class for table "janus_amqp_admin".
 *
 * @property int $id
 * @property string|null $value
 * @property int|null $refresh_count
 * @property int $type
 * @property int|null $status
 * @property int $created_at
 * @property int $updated_at
 */
class JanusAmqpAdmin extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_EXPIRED = 0;

    const TYPE_ADM_SESSION = 1;
    const TYPE_ADM_TOKEN = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_amqp_admin';
    }
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['refresh_count', 'type', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['refresh_count', 'type', 'status', 'created_at', 'updated_at'], 'integer'],
            [['type', 'created_at', 'updated_at'], 'required'],
            [['value'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'refresh_count' => 'Refresh Count',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static public function getActiveAdminToken(){
        $res = self::find()->where(['status' => self::STATUS_ACTIVE, 'type' => self::TYPE_ADM_TOKEN])->andWhere(new BetweenCondition('updated_at', 'BETWEEN', (\time() - 1800), \time()))->limit(1);
        if ($res->count() > 0) {
            return $res;
        }
        return null;
    }

    static public function addAdminToken(string $token)
    {
        self::invalidateAdminToken();
        $adm = new self;
        $adm->value = $token;
        $adm->type = self::TYPE_ADM_TOKEN;
        $adm->status = self::STATUS_ACTIVE;
        return $adm->save(false);
    }

    static function getActiveAdminSession()
    {
        $res = self::find()->where(['status' => self::STATUS_ACTIVE, 'type' => self::TYPE_ADM_SESSION])->andWhere(new BetweenCondition('updated_at', 'BETWEEN', (\time() - 60), \time()))->limit(1);
        if ($res->count() > 0) {
            return $res;
        }
        return null;
    }

    static public function addAdminSession(int $sessionId)
    {
        self::invalidateAdminSessions();
        $adm = new self;
        $adm->value = $sessionId;
        $adm->type = self::TYPE_ADM_SESSION;
        $adm->status = self::STATUS_ACTIVE;
        return $adm->save(false);
    }

    static public function sessionRefreshCount()
    {
        $sess = self::getActiveAdminSession();
        if (null === $sess) {
            return false;
        }
        $currSess = $sess->one();
        // if ($currSess->session_id != $sessionId) {
        //     return false;
        // }
        $currSess->refresh_count++;
        return $currSess->update(false) > 0 ? true : false;
    }


    static private function invalidateAdminSessions(): void
    {
        self::updateAll(['status' => self::STATUS_EXPIRED], ['status' => self::STATUS_ACTIVE, 'type' => self::TYPE_ADM_SESSION]);
    }
    static private function invalidateAdminToken(): void
    {
        self::updateAll(['status' => self::STATUS_EXPIRED], ['status' => self::STATUS_ACTIVE, 'type' => self::TYPE_ADM_TOKEN]);
    }
}
