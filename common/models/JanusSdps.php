<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_sdps".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property bool $remote
 * @property bool $off
 * @property string $sdp
 * @property int $created_at
 */
class JanusSdps extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_sdps';
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
            [['session', 'handle', 'remote', 'off', 'sdp'], 'required'],
            [['session', 'handle', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'created_at'], 'integer'],
            [['remote', 'off'], 'boolean'],
            [['sdp'], 'string', 'max' => 3000],
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
            'remote' => 'Remote',
            'off' => 'Off',
            'sdp' => 'Sdp',
            'created_at' => 'Created At',
        ];
    }
}
