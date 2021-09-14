<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "room_member".
 *
 * @property int $room_id
 * @property int $user_profile_id
 * @property string $token
 * @property int $mute_audio
 * @property int $mute_video
 * @property int $moderate_audio
 * @property int $moderate_video
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room $room
 * @property User $user
 * @property UserProfile $userProfile
 */
class RoomMember extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room_member';
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
            [['room_id', 'user_profile_id'], 'unique', 'targetAttribute' => ['room_id', 'user_profile_id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],
            ['token', 'string', 'max' => 36],
            ['token', 'unique'],
            ['token', 'thamtech\uuid\validators\UuidValidator'],
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
            'token' => 'Token',
            'mute_audio'=>'Muted audio',
            'mute_video'=>'Muted video',
            'moderate_audio'=>'Moderated audio',
            'moderate_video'=>'Moderated video',
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

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(RoomRequest::class, ['room_id' => 'room_id', 'user_profile_id' => 'user_profile_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->token = \thamtech\uuid\helpers\UuidHelper::uuid();
        }

        return parent::beforeSave($insert);
    }
}
