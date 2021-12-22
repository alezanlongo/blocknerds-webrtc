<?php

namespace common\models;

use Exception as GlobalException;
use Swoole\Http\Status;
use Yii;
use yii\base\InvalidConfigException;
use yii\base\NotSupportedException;
use yii\base\InvalidArgumentException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property int $meeting_id
 * @property string $uuid
 * @property int $status
 * @property boolean $is_quick
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Meeting $meeting
 * @property RoomMember[] $roomMembers
 * @property RoomRequest[] $roomRequests
 */
class Room extends \yii\db\ActiveRecord
{
    const STATUS_PENDING = 0;
    const STATUS_CREATED = 1;
    const STATUS_DESTROYED = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room';
    }

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
            [['meeting_id'], 'required'],
            [['meeting_id', 'status', 'created_at', 'updated_at'], 'integer'],
            ['is_quick', 'boolean'],
            ['uuid', 'string', 'max' => 36],
            ['uuid', 'unique'],
            ['uuid', 'thamtech\uuid\validators\UuidValidator'],
            [['meeting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Meeting::class, 'targetAttribute' => ['meeting_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meeting_id' => 'Meeting ID',
            'uuid' => 'Uuid',
            'status' => 'Status',
            'is_quick' => 'Is quick',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * 
     * @param string $roomUuid 
     * @param array $columns Columns to returns. Passing an empty array will be returns all columns
     * @return ActiveRecord|array|null 
     */
    public static function getRoomByUuid(string $roomUuid, array $columns = ['id', 'uuid'])
    {
        $f = self::find();
        if (!empty($columns)) {
            $f->select(\join(",", $columns));
        }
        return $f->where(['uuid' => $roomUuid])->one();
    }

    /**
     * Gets query for [[Meeting]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMeeting()
    {
        return $this->hasOne(Meeting::class, ['id' => 'meeting_id']);
    }

    public function getOwner()
    {
        $meeting = $this->getMeeting()->limit(1)->one();
        return $meeting->getOwner()->limit(1)->one();
    }

    /**
     * Gets query for [[RoomMembers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomMembers()
    {
        return $this->hasMany(RoomMember::class, ['room_id' => 'id']);
    }

    /**
     * Gets query for [[RoomRequests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoomRequests()
    {
        return $this->hasMany(RoomRequest::class, ['room_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
        }

        return parent::beforeSave($insert);
    }
}
