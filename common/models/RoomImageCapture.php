<?php

namespace common\models;

use yii;
use yii\behaviors\TimestampBehavior;
use yii\db\conditions\BetweenCondition;

/**
 * This is the model class for table "room_image_capture".
 *
 * @property int $id
 * @property string $capture_id
 * @property int $room_id
 * @property int $user_profile_id
 * @property int $target_user_profile_id
 * @property string|null $filename
 * @property int|null $file_format
 * @property int $capture_type
 * @property int $status
 * @property int|null $captured_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room $room
 * @property User $user
 * @property User $targetUser
 */
class RoomImageCapture extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 0;
    const STATUS_PROCESSED = 10;
    const STATUS_FAIL = -1;
    const CAPTURE_TYPE_USER_CAMERA = 1;
    const CAPTURE_TYPE_WINDOW = 2;
    const FILE_FORMAT_PNG = 1;
    const FILE_FORMAT_JPG = 2;
    const FILE_FORMAT_GIF = 3;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room_image_capture';
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
            [['capture_id'], 'string'],
            [['room_id', 'user_profile_id', 'target_user_profile_id', 'capture_type', 'status', 'created_at', 'updated_at'], 'required'],
            [['room_id', 'user_profile_id', 'target_user_profile_id', 'file_format', 'capture_type', 'status', 'captured_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['room_id', 'user_profile_id', 'target_user_profile_id', 'file_format', 'capture_type', 'status', 'captured_at', 'created_at', 'updated_at'], 'integer'],
            [['filename'], 'string', 'max' => 255],
            [['capture_id'], 'unique'],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['user_profile_id' => 'id']],
            [['target_user_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['target_user_profile_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'capture_id' => 'Capture ID',
            'room_id' => 'Room ID',
            'user_profile_id' => 'User Profile ID',
            'target_user_profile_id' => 'Target User Profile ID',
            'filename' => 'Filename',
            'file_format' => 'File Format',
            'capture_type' => 'Capture Type',
            'status' => 'Status',
            'captured_at' => 'Captured At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    static public function hasPendingCatures(int $roomId, int $targetUserProfileId): bool
    {
        return self::find()->where(['room_id' => $roomId, 'target_user_profile_id' => $targetUserProfileId, 'status' => self::STATUS_PENDING])->andWhere(new BetweenCondition('created_at', 'BETWEEN', (\time() - 10), \time()))->count() > 0;
    }

    static public function getByTargetUserProfile(int $roomId, int $targetUserProfileId)
    {
        return self::findOne(['room_id' => $roomId, 'target_user_profile_id' => $targetUserProfileId, 'status' => self::STATUS_PENDING]);
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
     * Gets query for [[UserProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'user_profile_id']);
    }

    /**
     * Gets query for [[TargetUserProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTargetUserProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'target_user_profile_id']);
    }
}
