<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "meeting".
 *
 * @property int $id
 * @property string $title
 * @property string|null $description
 * @property int $owner_id
 * @property int $duration
 * @property int $scheduled_at
 * @property int $reminder_time
 * @property boolean $allow_waiting
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Room[] $rooms
 */
class Meeting extends \yii\db\ActiveRecord
{
    const DEFAULT_DURATION = 3600; // one hour
    const DEFAULT_TITLE = "quick meeting";

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meeting';
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
            [['title', 'owner_id', 'duration', 'scheduled_at'], 'required'],
            [['owner_id', 'duration', 'scheduled_at', 'reminder_time', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description'], 'string', 'max' => 255],
            ['allow_waiting', 'boolean'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'owner_id' => 'Owner ID',
            'duration' => 'Duration',
            'scheduled_at' => 'Scheduled At',
            'reminder_time' => 'Reminder Time',
            'allow_waiting' => 'Allow Waiting',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Gets query for [[Rooms]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(Room::class, ['meeting_id' => 'id']);
    }

    public function getOwner()
    {
        return $this->hasOne(UserProfile::class, ['id' => 'owner_id']);
    }
}
