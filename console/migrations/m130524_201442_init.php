<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        // user
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'verification_token' => $this->string()->defaultValue(null),
            'is_admin' => $this->boolean()->notNull()->defaultValue(false),
            'ext_practice_id' => $this->integer(),
            'ext_provider_id' => $this->integer(),
            'ext_provider_username' => $this->string(),
        ], $tableOptions);

        // user_profile
        $this->createTable('{{%user_profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull()->unique(),
            'first_name' => $this->string(100),
            'last_name' => $this->string(100),
            'phone' => $this->string(36),
            'timezone' => $this->string(60)->defaultValue('UTC'),
            'locale' => $this->string(10)->defaultValue('en_US'),
            'image' => $this->string(255),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-user_profile-user_id}}',
            '{{%user_profile}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // user_setting
        $this->createTable('{{%user_setting}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'group_name' => $this->string(),
            'name' => $this->string(),
            'data_type' => $this->string(),
            'value' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-user_setting-user_id}}',
            '{{%user_setting}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-constraint-user_setting-group_name-name-user_id}}',
            '{{%user_setting}}',
            ['group_name', 'name', 'user_id'],
            true
        );

        // meeting
        $this->createTable('{{%meeting}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->string(),
            'owner_id' => $this->integer()->notNull(),
            'duration' => $this->integer()->notNull(),
            'scheduled_at' => $this->integer()->notNull(),
            'reminder_time' => $this->smallInteger()->notNull()->defaultValue(0),
            'allow_waiting' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-meeting-owner_id}}',
            '{{%meeting}}',
            'owner_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        // room
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'meeting_id' => $this->integer()->notNull(),
            'uuid' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'is_quick' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-room-meeting_id}}',
            '{{%room}}',
            'meeting_id',
            '{{%meeting}}',
            'id',
            'CASCADE'
        );

        // room_member
        $this->createTable('{{%room_member}}', [
            'room_id' => $this->integer()->notNull(),
            'user_profile_id' => $this->integer()->notNull(),
            'token' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'PRIMARY KEY(room_id, user_profile_id)',
            'mute_audio' => $this->boolean()->notNull()->defaultValue(false),
            'mute_video' => $this->boolean()->notNull()->defaultValue(false),
            'moderate_audio' => $this->boolean()->notNull()->defaultValue(false),
            'moderate_video' => $this->boolean()->notNull()->defaultValue(false),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-room_member-room_id}}',
            '{{%room_member}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-room_member-user_profile_id}}',
            '{{%room_member}}',
            'user_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            '{{%idx-room_member-token}}',
            '{{%room_member}}',
            'token',
        );

        // room_request
        $this->createTable('{{%room_request}}', [
            'room_id' => $this->integer()->notNull(),
            'user_profile_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),
            'attempts' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY(room_id, user_profile_id)',
        ]);

        $this->addForeignKey(
            '{{%fk-room_request-room_id}}',
            '{{%room_request}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-room_request-user_profile_id}}',
            '{{%room_request}}',
            'user_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        // chat
        $this->createTable('{{%chat}}', [
            'id' => $this->primaryKey(),
            'from_profile_id' => $this->integer()->notNull(),
            'to_profile_id' => $this->integer(),
            'room_id' => $this->integer(),
            'channel' => $this->string(32)->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-chat-room_id}}',
            '{{%chat}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-chat-to_profile_id}}',
            '{{%chat}}',
            'to_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            '{{%fk-chat-from_profile_id}}',
            '{{%chat}}',
            'from_profile_id',
            '{{%user_profile}}',
            'id',
            'CASCADE'
        );

        // chat_message
        $this->createTable('{{%chat_message}}', [
            'id' => $this->primaryKey(),
            'chat_id' => $this->integer()->notNull(),
            'text' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            '{{%fk-chat_message-chat_id}}',
            '{{%chat_message}}',
            'chat_id',
            '{{%chat}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // chat_message
        $this->dropForeignKey(
            '{{%fk-chat_message-chat_id}}',
            '{{%chat_message}}'
        );
        $this->dropTable('{{%chat_message}}');

        // chat
        $this->dropForeignKey(
            '{{%fk-chat-room_id}}',
            '{{%chat}}'
        );
        $this->dropForeignKey(
            '{{%fk-chat-from_profile_id}}',
            '{{%chat}}'
        );
        $this->dropForeignKey(
            '{{%fk-chat-to_profile_id}}',
            '{{%chat}}'
        );
        $this->dropTable('{{%chat}}');

        // meeting
        $this->dropTable('{{%meeting}}');

        // room_chat
        $this->dropForeignKey(
            '{{%fk-room_chat-room_id}}',
            '{{%room_chat}}'
        );
        $this->dropForeignKey(
            '{{%fk-room_chat-user_profile_id}}',
            '{{%room_chat}}'
        );
        $this->dropTable('{{%room_chat}}');

        // room_request
        $this->dropForeignKey(
            '{{%fk-room_request-room_id}}',
            '{{%room_request}}'
        );
        $this->dropForeignKey(
            '{{%fk-room_request-user_profile_id}}',
            '{{%room_request}}'
        );
        $this->dropTable('{{%room_request}}');

        // room_member
        $this->dropIndex(
            '{{%idx-room_member-token}}',
            '{{%room_member}}',
            'token',
        );
        $this->dropForeignKey(
            '{{%fk-room_member-room_id}}',
            '{{%room_member}}'
        );
        $this->dropForeignKey(
            '{{%fk-room_member-user_profile_id}}',
            '{{%room_member}}'
        );
        $this->dropTable('{{%room_member}}');

        // room
        $this->execute('DROP EXTENSION IF EXISTS "uuid-ossp";');
        $this->dropForeignKey(
            '{{%fk-room-meeting_id}}',
            '{{%room}}'
        );
        $this->dropTable('{{%room}}');

        // user_setting
        $this->dropForeignKey(
            '{{%fk-user_setting-user_id}}',
            '{{%user_setting}}'
        );
        $this->dropTable('{{%user_setting}}');

        // user_profile
        $this->dropForeignKey(
            '{{%fk-user_profile-user_id}}',
            '{{%user_profile}}'
        );
        $this->dropTable('{{%user_profile}}');

        // user
        $this->dropTable('{{%user}}');
    }
}
