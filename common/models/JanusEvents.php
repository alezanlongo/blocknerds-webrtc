<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "janus_events".
 *
 * @property int $id
 * @property int $type
 * @property int|null $session
 * @property int|null $handle
 * @property string|null $event
 * @property string|null $data
 * @property string|null $plugin
 * @property string|null $name
 * @property string|null $value
 * @property bool|null $remote
 * @property bool|null $off
 * @property string|null $sdp
 * @property int|null $stream
 * @property int|null $component
 * @property string|null $state
 * @property string|null $selected
 * @property string|null $medium
 * @property bool|null $receiving
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
 * @property int $event_timestamp
 * @property int $created_at
 */
class JanusEvents extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'janus_events';
    }

    /**
     * {@inheritdoc}
     */
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
            [['type', 'event_timestamp', 'created_at'], 'required'],
            [['type', 'session', 'handle', 'stream', 'component', 'base', 'lsr', 'lostlocal', 'lostremote', 'jitterlocal', 'jitterremote', 'packetssent', 'packetsrecv', 'bytessent', 'bytesrecv', 'nackssent', 'nacksrecv', 'event_timestamp', 'created_at'], 'default', 'value' => null],
            [['type', 'session', 'handle', 'stream', 'component', 'base', 'lsr', 'lostlocal', 'lostremote', 'jitterlocal', 'jitterremote', 'packetssent', 'packetsrecv', 'bytessent', 'bytesrecv', 'nackssent', 'nacksrecv', 'event_timestamp', 'created_at'], 'integer'],
            [['remote', 'off', 'receiving'], 'boolean'],
            [['event', 'data', 'sdp'], 'string', 'max' => 3000],
            [['plugin'], 'string', 'max' => 100],
            [['name', 'value', 'state', 'medium'], 'string', 'max' => 30],
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
            'type' => 'Type',
            'session' => 'Session',
            'handle' => 'Handle',
            'event' => 'Event',
            'data' => 'Data',
            'plugin' => 'Plugin',
            'name' => 'Name',
            'value' => 'Value',
            'remote' => 'Remote',
            'off' => 'Off',
            'sdp' => 'Sdp',
            'stream' => 'Stream',
            'component' => 'Component',
            'state' => 'State',
            'selected' => 'Selected',
            'medium' => 'Medium',
            'receiving' => 'Receiving',
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
            'event_timestamp' => 'Event Timestamp',
            'created_at' => 'Created At',
        ];
    }
}
