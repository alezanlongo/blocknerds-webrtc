<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "room_chat".
 *
 * @property int $id
 * @property int $room_id
 * @property int $user_profile_id
 * @property string $message
 * @property string|null $file_url
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room $room
 * @property User $user
 * @property UserProfile $userProfile
 */
class RoomChat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room_chat';
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
            [['room_id', 'user_profile_id', 'created_at', 'updated_at'], 'integer'],
            [['message', 'file_url'], 'string', 'max' => 255],
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
            'id' => 'ID',
            'room_id' => 'Room ID',
            'user_profile_id' => 'User Profile ID',
            'message' => 'Message',
            'file_url' => 'File Url',
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
