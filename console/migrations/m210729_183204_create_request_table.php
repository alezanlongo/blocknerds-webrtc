<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%request}}`.
 */
class m210729_183204_create_request_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%request}}', [
            'room_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),
            'attempts' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY(room_id, user_id)',
        ]);

        // add foreign key for table `{{%request}}`
        $this->addForeignKey(
            '{{%fk-request-room_id}}',
            '{{%request}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            '{{%fk-request-room_id}}',
            '{{%request}}'
        );

        $this->dropForeignKey(
            '{{%fk-request-user_id}}',
            '{{%request}}'
        );

        $this->dropTable('{{%request}}');
    }
}
