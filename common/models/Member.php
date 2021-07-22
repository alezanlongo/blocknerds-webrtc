<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $room_id
 * @property int $user_id
 * @property int $status
 *
 * @property Room $room
 * @property User $user
 */
class Member extends \yii\db\ActiveRecord
{
    const STATUS_DENY = 0;
    const STATUS_ALLOW = 1;
    const STATUS_PENDING = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'member';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['room_id', 'user_id'], 'required'],
            [['room_id', 'user_id', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_PENDING],
            ['status', 'in', 'range' => [self::STATUS_DENY, self::STATUS_ALLOW, self::STATUS_PENDING]],
            [['room_id', 'user_id'], 'unique', 'targetAttribute' => ['room_id', 'user_id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'room_id' => 'Room ID',
            'user_id' => 'User ID',
            'status' => 'Status',
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
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
