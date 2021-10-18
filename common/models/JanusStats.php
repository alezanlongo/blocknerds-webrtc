<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_stats".
 *
 * @property int $id
 * @property int $session
 * @property int $handle
 * @property string $medium
 * @property int|null $base
 * @property int|null $lsr
 * @property int|null $lostlocal
 * @property int|null $lostremote
 * @property int|null $jitterlocal
 * @property int|null $jitterremote
 * @property int|null $packetssent
 * @property int|null $packetsrecv
 * @property int|null $bytessent
 * @property int|null $bytesrecv
 * @property int|null $nackssent
 * @property int|null $nacksrecv
 * @property int $created_at
 */
class JanusStats extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_stats';
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
            [['session', 'handle', 'medium'], 'required'],
            [['session', 'handle', 'base', 'lsr', 'lostlocal', 'lostremote', 'jitterlocal', 'jitterremote', 'packetssent', 'packetsrecv', 'bytessent', 'bytesrecv', 'nackssent', 'nacksrecv', 'created_at'], 'default', 'value' => null],
            [['session', 'handle', 'base', 'lsr', 'lostlocal', 'lostremote', 'jitterlocal', 'jitterremote', 'packetssent', 'packetsrecv', 'bytessent', 'bytesrecv', 'nackssent', 'nacksrecv', 'created_at'], 'integer'],
            [['medium'], 'string', 'max' => 30],
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
            'medium' => 'Medium',
            'base' => 'Base',
            'lsr' => 'Lsr',
            'lostlocal' => 'Lostlocal',
            'lostremote' => 'Lostremote',
            'jitterlocal' => 'Jitterlocal',
            'jitterremote' => 'Jitterremote',
            'packetssent' => 'Packetssent',
            'packetsrecv' => 'Packetsrecv',
            'bytessent' => 'Bytessent',
            'bytesrecv' => 'Bytesrecv',
            'nackssent' => 'Nackssent',
            'nacksrecv' => 'Nacksrecv',
            'created_at' => 'Created At',
        ];
    }
}
