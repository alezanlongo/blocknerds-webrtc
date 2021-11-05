<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%janus_amqp_message}}`.
 */
class m211101_144227_create_janus_amqp_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%janus_amqp_message}}', [
            'id' => $this->primaryKey(),
            'parent_id' => $this->integer()->null(),
            'transaction_id' => $this->string(50)->notNull(),
            // 'is_controller' => $this->boolean()->notNull(),
            'reference_id'=>$this->string(50)->null(),
            'session' => $this->bigInteger(30),
            'action_type' => $this->integer(3),
            'status' => $this->integer(3)->defaultValue(0),
            'attributes' => $this->json(),
            'attempts' => $this->integer(2)->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->createIndex(
            '{{%idx-janus_amqp_message-transaction_id}}',
            '{{%janus_amqp_message}}',
            'transaction_id'
        );
        $this->createIndex(
            '{{%idx-janus_amqp_message-reference_id}}',
            '{{%janus_amqp_message}}',
            'reference_id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%janus_amqp_message}}');
    }
}
