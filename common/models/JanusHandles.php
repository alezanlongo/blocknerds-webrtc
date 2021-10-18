<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_handles".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property string $event
 * @property string $plugin
 * @property int $created_at
 */
class JanusHandles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_handles';
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
            [['session', 'handle', 'event', 'plugin'], 'required'],
            [['session', 'handle', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'created_at'], 'integer'],
            [['event'], 'string', 'max' => 30],
            [['plugin'], 'string', 'max' => 100],
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
            'handle' => 'Handle',
            'event' => 'Event',
            'plugin' => 'Plugin',
            'created_at' => 'Created At',
        ];
    }
}
