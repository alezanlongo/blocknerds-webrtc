<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_connections".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property string $state
 * @property int $created_at
 */
class JanusConnections extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_connections';
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
            [['session', 'handle', 'state'], 'required'],
            [['session', 'handle', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'created_at'], 'integer'],
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
            'state' => 'State',
            'created_at' => 'Created At',
        ];
    }
}
