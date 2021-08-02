<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "member".
 *
 * @property int $room_id
 * @property int $user_id
 * @property string $token
 *
 * @property Room $room
 * @property User $user
 */
class Member extends \yii\db\ActiveRecord
{
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
            [['room_id', 'user_id'], 'integer'],
            [['room_id', 'user_id'], 'unique', 'targetAttribute' => ['room_id', 'user_id']],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => Room::class, 'targetAttribute' => ['room_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
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
            'user_id' => 'User ID',
            'token' => 'Token',
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

    /**
     * Gets query for [[Request]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequest()
    {
        return $this->hasOne(Request::class, ['room_id' => 'room_id', 'user_id' => 'user_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->token = \thamtech\uuid\helpers\UuidHelper::uuid();
        }

        return parent::beforeSave($insert);
    }
}
