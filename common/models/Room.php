<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property string $title
 * @property string $uuid
 * @property int $owner_id
 * @property int $duration
 * @property int $scheduled_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property RoomMember[] $members
 * @property User[] $users
 */
class Room extends \yii\db\ActiveRecord
{
    const DEFAULT_DURATION = 60;
    const DEFAULT_TITLE = "quick meeting";

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
            ['uuid', 'string', 'max' => 36],
            ['uuid', 'unique'],
            ['uuid', 'thamtech\uuid\validators\UuidValidator'],
            ['title', 'string'],
            [['title', 'duration', 'owner_id', 'scheduled_at'], 'required'],
            [['owner_id', 'duration', 'scheduled_at', 'created_at', 'updated_at'], 'integer'],
            ['owner_id', 'exist', 'targetClass' => User::class, 'targetAttribute' => ['owner_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uuid' => 'Uuid',
            'owner_id' => 'Owner ID',
            'scheduled_at' => 'Scheduled At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Members]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMembers()
    {
        return $this->hasMany(RoomMember::class, ['room_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['id' => 'user_id'])->viaTable('member', ['room_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->uuid = \thamtech\uuid\helpers\UuidHelper::uuid();
        }

        return parent::beforeSave($insert);
    }
}
