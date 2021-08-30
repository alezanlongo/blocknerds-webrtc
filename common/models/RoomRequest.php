<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "room_request".
 *
 * @property int $room_id
 * @property int $user_profile_id
 * @property int $status
 * @property int $attempts
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room $room
 * @property User $user
 * @property UserProfile $userProfile
 */
class RoomRequest extends \yii\db\ActiveRecord
{
    const STATUS_DENY = 0;
    const STATUS_ALLOW = 1;
    const STATUS_PENDING = 2;
    const MAX_ATTEMPTS = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room_request';
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
            [['room_id', 'user_profile_id'], 'required'],
            [['room_id', 'user_profile_id', 'status', 'attempts', 'created_at', 'updated_at'], 'integer'],
            [['room_id', 'user_profile_id'], 'unique', 'targetAttribute' => ['room_id', 'user_profile_id']],
            ['attempts', 'default', 'value' => 0],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => [self::STATUS_DENY, self::STATUS_ALLOW, self::STATUS_PENDING]],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'room_id' => 'Room ID',
            'user_profile_id' => 'User Profile ID',
            'status' => 'Status',
            'attempts' => 'Attempts',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Room]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::class, ['id' => 'room_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        $profile = UserProfile::findOne($this->user_profile_id);
        return $profile->getUser()->one();
    }

    /**
     * Gets query for [[UserProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'user_profile_id']);
    }
}
