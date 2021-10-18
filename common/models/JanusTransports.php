<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_transports".
 *
 * @property int $id
 * @property int|null $session
 * @property int|null $handle
 * @property string $plugin
 * @property string $event
 * @property int $created_at
 */
class JanusTransports extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_transports';
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
            [['session', 'handle', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'created_at'], 'integer'],
            [['plugin', 'event'], 'required'],
            [['plugin'], 'string', 'max' => 100],
            [['event'], 'string', 'max' => 3000],
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
            'plugin' => 'Plugin',
            'event' => 'Event',
            'created_at' => 'Created At',
        ];
    }
}
