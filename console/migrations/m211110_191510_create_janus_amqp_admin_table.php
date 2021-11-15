<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%janus_amqp_admin}}`.
 */
class m211110_191510_create_janus_amqp_admin_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%janus_amqp_admin}}', [
            'id' => $this->primaryKey(),
            'value' => $this->string(),
            'refresh_count' => $this->integer()->defaultValue(0),
            'type' => $this->integer(3)->notNull(),
            'status' => $this->integer(3)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            '{{%idx-janus_amqp_admin-value}}',
            '{{%janus_amqp_admin}}',
            'value'
        );

        $this->createIndex(
            '{{%idx-janus_amqp_admin-type}}',
            '{{%janus_amqp_admin}}',
            'type'
        );

        $this->createIndex(
            '{{%idx-janus_amqp_admin-updated_at}}',
            '{{%janus_amqp_admin}}',
            'updated_at'
        );

        $this->createIndex(
            '{{%idx-janus_amqp_admin-status}}',
            '{{%janus_amqp_admin}}',
            'status'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%janus_amqp_admin}}');
    }
}
