<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ice_event_log".
 *
 * @property int $id
 * @property string|null $log
 * @property string|null $sdp_log
 * @property int $profile_id
 * @property int $room_id
 * @property int $created_at
 * @property int $updated_at
 *
 * @property RoomMember $profile
 */

class IceEventLog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ice_event_log';
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
            [['log','sdp_log'], 'safe'],
            [['profile_id', 'room_id'], 'required'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id','room_id','created_at', 'updated_at'], 'integer'],
            [['profile_id', 'room_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoomMember::class, 'targetAttribute' => ['profile_id' => 'user_profile_id', 'room_id' => 'room_id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'log' => 'Log',
            'sdp_log' => 'Sdp Log',
            'profile_id' => 'Profile ID',
            'room_id' => 'Room ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // public function beforeSave($insert)
    // {
    //     if (!parent::beforeSave($insert)) {
    //         return false;
    //     }

    //     $this->profile_id = Yii::$app->user->identity->userProfile->id;
        
    //     return true;
    // }
    public function afterSave($insert, $changedAttributes)
    {
        // if ($insert) {
        //     $roomMember = RoomMember::findOne(['room_id'=>$this->room_id, 'profile_id'=>$this->profile_id]);
        //     $tree = new Tree();
        //     $tree->root = $roomMember->room->uuid;
    
        //     // parent::afterSave();
        // }
        return parent::afterSave($insert, $changedAttributes);
    }

    public function getRoomMember()
    {
        return $this->hasOne(RoomMember::class, ['user_profile_id' => 'profile_id', 'room_id' => 'room_id']);
    }
}
