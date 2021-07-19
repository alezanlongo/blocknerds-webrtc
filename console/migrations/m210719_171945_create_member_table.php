<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%member}}`.
 */
class m210719_171945_create_member_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%member}}', [
            'room_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'PRIMARY KEY(room_id, user_id)',
        ]);

        // add foreign key for table `{{%member}}`
        $this->addForeignKey(
            '{{%fk-member-room_id}}',
            '{{%member}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-member-user_id}}',
            '{{%member}}',
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
            '{{%fk-member-room_id}}',
            '{{%member}}'
        );

        $this->dropForeignKey(
            '{{%fk-member-user_id}}',
            '{{%member}}'
        );

        $this->dropTable('{{%member}}');
    }
}
