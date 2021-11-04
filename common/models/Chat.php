<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat".
 *
 * @property int $id
 * @property int $from_profile_id
 * @property int|null $to_profile_id
 * @property int|null $room_id
 * @property string $channel
 * @property string $text
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room $room
 * @property UserProfile $fromProfile
 * @property UserProfile $toProfile
 */
class Chat extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'chat';
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
            [['from_profile_id', 'channel', 'text'], 'required'],
            [['from_profile_id', 'to_profile_id', 'room_id', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['from_profile_id', 'to_profile_id', 'room_id', 'created_at', 'updated_at'], 'integer'],
            [['channel'], 'string', 'max' => 32],
            [['text'], 'string', 'max' => 255],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['from_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['from_profile_id' => 'id']],
            [['to_profile_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserProfile::class, 'targetAttribute' => ['to_profile_id' => 'id']],
        ];
    }
    
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_profile_id' => 'From Profile ID',
            'to_profile_id' => 'To Profile ID',
            'room_id' => 'Room ID',
            'channel' => 'Channel',
            'text' => 'Text',
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
     * Gets query for [[FromProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFromProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'from_profile_id']);
    }

    /**
     * Gets query for [[ToProfile]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getToProfile()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'to_profile_id']);
    }
}
