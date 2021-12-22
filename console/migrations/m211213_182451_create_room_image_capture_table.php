<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room_image_capture}}`.
 */
class m211213_182451_create_room_image_capture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%room_image_capture}}', [
            'id' => $this->primaryKey(),
            'capture_id' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'room_id' => $this->integer()->notNull(),
            'user_profile_id' => $this->integer()->notNull(),
            'target_user_profile_id' => $this->integer()->notNull(),
            'filename' => $this->string()->null(),
            'file_format' => $this->integer()->null(),
            'capture_type' => $this->integer(2)->notNull(),
            'status' => $this->integer(3)->notNull(),
            'captured_at' => $this->integer()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull()
        ]);

        $this->addForeignKey(
            '{{%fk-room_image_capture-room_id}}',
            '{{%room_image_capture}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-room_image_capture-user_id}}',
            '{{%room_image_capture}}',
            'user_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-room_image_capture-target_user_id}}',
            '{{%room_image_capture}}',
            'target_user_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-room_image_capture-capture_id}}',
            '{{%room_image_capture}}',
            'capture_id',
        );

        $this->createIndex(
            '{{%idx-room_image_capture-status}}',
            '{{%room_image_capture}}',
            'status',
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room_image_capture}}');
    }
}
