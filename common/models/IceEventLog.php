<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "ice_event_log".
 *
 * @property int $id
 * @property string $log
 * @property int $created_at
 * @property int $updated_at
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
            [['log'], 'required'],
            [['log'], 'safe'],
            [['created_at', 'updated_at'], 'default', 'value' => null],
            [['profile_id','created_at', 'updated_at'], 'integer'],
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        $this->profile_id = Yii::$app->user->identity->userProfile->id;
        
        return true;
    }
}
