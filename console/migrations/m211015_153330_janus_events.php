<?php

use yii\db\Migration;

/**
 * Class m211015_153330_janus_events
 */
class m211015_153330_janus_events extends Migration
{
    public function up()
    {
        $tableOptions = null;

        $this->createTable('{{%janus_events}}', [
            'id' => $this->primaryKey(),
            'type' => $this->smallInteger()->notNull(),
            'session' => $this->bigInteger(30),
            'handle' => $this->bigInteger(30),
            'event' => $this->string(3000),
            'data' => $this->string(3000),
            'plugin' => $this->string(100),
            'name' => $this->string(30),
            'value' => $this->string(30),
            'remote' => $this->boolean(),
            'off' => $this->boolean(),
            'sdp' => $this->string(3000),
            'stream' => $this->integer(),
            'component' => $this->integer(),
            'state' => $this->string(30),
            'selected' => $this->string(200),
            'medium' => $this->string(30),
            'receiving' => $this->boolean(),
            'base' => $this->integer(),
            'lsr' => $this->integer(),
            'lostlocal' => $this->integer(),
            'lostremote' => $this->integer(),
            'jitterlocal' => $this->integer(),
            'jitterremote' => $this->integer(),
            'packetssent' => $this->integer(),
            'packetsrecv' => $this->integer(),
            'bytessent' => $this->bigInteger(),
            'bytesrecv' => $this->bigInteger(),
            'nackssent' => $this->integer(),
            'nacksrecv' => $this->integer(),
            'event_timestamp' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%janus_events}}');
    }
}
