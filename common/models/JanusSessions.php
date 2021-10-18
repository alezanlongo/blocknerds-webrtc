<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_sessions".
 *
 * @property int $id
 * @property int $session
 * @property string $event
 * @property int $event_timestamp
 * @property int $created_at
 */
class JanusSessions extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_sessions';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'updatedAtAttribute' => false,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['session', 'event'], 'required'],
            [['session', 'created_at','event_timestamp'], 'default', 'value' => null],
            [['session', 'created_at','event_timestamp'], 'integer'],
            [['event'], 'string', 'max' => 30],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'session' => 'Session',
            'event' => 'Event',
            'event_timestamp'=>'Event timestamp',
            'created_at' => 'Created At',
        ];
    }
}
