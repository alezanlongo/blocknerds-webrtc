<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "janus_amqp_message".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string $transaction_id
 * @property string|null $reference_id
 * @property int|null $session
 * @property int|null $action_type
 * @property int|null $status
 * @property array|null $attributes
 * @property int|null $attempts
 * @property int $created_at
 * @property int $updated_at
 */
class JanusAmqpMessage extends \yii\db\ActiveRecord
{

    const ACTION_TYPE_CREATE_ROOM = 1;
    const ACTION_TYPE_CREATE_SESSION = 2;
    const ACTION_TYPE_ATTACH_PLUGIN = 3;
    const ACTION_TYPE_GET_STORED_TOKEN = 4;
    const ACTION_TYPE_GET_ADMIN_TOKEN = 5;
    const ACTION_TYPE_CREATE_TOKEN = 6;
    const STATUS_PENDING = 0;
    const STATUS_PROCESSING = 1;
    const STATUS_COMPLETED = 10;
    const STATUS_FAIL = -1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_amqp_message';
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
            [['parent_id', 'session', 'action_type', 'status', 'attempts', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['parent_id', 'session', 'action_type', 'status', 'attempts', 'created_at', 'updated_at'], 'integer'],
            [['transaction_id', 'created_at', 'updated_at'], 'required'],
            [['attributes'], 'safe'],
            [['transaction_id', 'reference_id'], 'string', 'max' => 50],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'transaction_id' => 'Transaction ID',
            'reference_id' => 'Reference ID',
            'session' => 'Session',
            'action_type' => 'Action Type',
            'status' => 'Status',
            'attributes' => 'Attributes',
            'attempts' => 'Attempts',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function isParent()
    {
        return $this->parent_id === null ? true : false;
    }

    public function getChildren()
    {
        return $this->hasMany(self::class, ['parent_id' => 'id']);
    }


    public function getParent()
    {
        return $this->hasOne(self::class, ['id' => 'parent_id']);
    }


    public function beforeSave($insert)
    {
        $this->attempts = ($this->attempts === null ? 0 : $this->attempts + 1);
        return parent::beforeSave($insert);
    }
}
