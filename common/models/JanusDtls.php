<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_dtls".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property int $stream
 * @property int $component
 * @property string $state
 * @property int $created_at
 */
class JanusDtls extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_dtls';
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
            [['session', 'handle', 'stream', 'component', 'state'], 'required'],
            [['session', 'handle', 'stream', 'component', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'stream', 'component', 'created_at'], 'integer'],
            [['state'], 'string', 'max' => 30],
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
            'stream' => 'Stream',
            'component' => 'Component',
            'state' => 'State',
            'created_at' => 'Created At',
        ];
    }
}
