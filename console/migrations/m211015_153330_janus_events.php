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

        $this->createTable('{{%janus_sessions}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'event' => $this->string(30)->notNull(),
            'event_timestamp'=>$this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_handles}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'event' => $this->string(30)->notNull(),
            'plugin' => $this->string(100)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_core}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(30)->notNull(),
            'value' => $this->string(30)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_sdps}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'remote' => $this->boolean()->notNull(),
            'off' => $this->boolean()->notNull(),
            'sdp' => $this->string(3000)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_ice}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'stream' => $this->integer()->notNull(),
            'component' => $this->integer()->notNull(),
            'state' => $this->string(30)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_selectedpairs}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'stream' => $this->integer()->notNull(),
            'component' => $this->integer()->notNull(),
            'selected' => $this->string(200)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_dtls}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'stream' => $this->integer()->notNull(),
            'component' => $this->integer()->notNull(),
            'state' => $this->string(30)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_connections}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'state' => $this->string(30)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_media}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'medium' => $this->string(30)->notNull(),
            'receiving' => $this->boolean()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_stats}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30)->notNull(),
            'handle' => $this->bigInteger(30)->notNull(),
            'medium' => $this->string(30)->notNull(),
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
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_plugins}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30),
            'handle' => $this->bigInteger(30),
            'plugin' => $this->string(100)->notNull(),
            'event' => $this->string(3000)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%janus_transports}}', [
            'id' => $this->primaryKey(),
            'session' => $this->bigInteger(30),
            'handle' => $this->bigInteger(30),
            'plugin' => $this->string(100)->notNull(),
            'event' => $this->string(3000)->notNull(),
            'created_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%janus_sessions}}');
        $this->dropTable('{{%janus_handles}}');
        $this->dropTable('{{%janus_core}}');
        $this->dropTable('{{%janus_sdps}}');
        $this->dropTable('{{%janus_ice}}');
        $this->dropTable('{{%janus_selectedpairs}}');
        $this->dropTable('{{%janus_dtls}}');
        $this->dropTable('{{%janus_connections}}');
        $this->dropTable('{{%janus_media}}');
        $this->dropTable('{{%janus_stats}}');
        $this->dropTable('{{%janus_plugins}}');
        $this->dropTable('{{%janus_transports}}');
    }
}
