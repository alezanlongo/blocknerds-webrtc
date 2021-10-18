<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_selectedpairs".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property int $stream
 * @property int $component
 * @property string $selected
 * @property int $created_at
 */
class JanusSelectedpairs extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_selectedpairs';
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
            [['session', 'handle', 'stream', 'component', 'selected'], 'required'],
            [['session', 'handle', 'stream', 'component', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'stream', 'component', 'created_at'], 'integer'],
            [['selected'], 'string', 'max' => 200],
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
            'selected' => 'Selected',
            'created_at' => 'Created At',
        ];
    }
}
