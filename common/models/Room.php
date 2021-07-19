<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "room".
 *
 * @property int $id
 * @property string $uuid
 * @property int $owner_id
 * @property int $scheduled_at
 * @property int $created_at
 * @property int $updated_at
 *
 * @property Member[] $members
 * @property User[] $users
 */
class Room extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'room';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['uuid'], 'string'],
            [['owner_id', 'scheduled_at', 'created_at', 'updated_at'], 'required'],
            [['owner_id', 'scheduled_at', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['owner_id', 'scheduled_at', 'created_at', 'updated_at'], 'integer'],
            [['uuid'], 'unique'],
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
        return $this->hasMany(Member::className(), ['room_id' => 'id']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('member', ['room_id' => 'id']);
    }
}
