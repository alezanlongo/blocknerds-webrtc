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
            'user_id' => $this->integer()->notNull()->unique(),
            'group_name' => $this->string(),
            'name' => $this->string(),
            'data_type' => $this->string(),
            'value' => $this->string(),
        ]);

        $this->addForeignKey(
            '{{%fk-user_setting-user_id}}',
            '{{%user_setting}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
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
            'allow_waiting' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // room
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'meeting_id' => $this->integer()->notNull(),
            'uuid' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
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
            'user_id' => $this->integer()->notNull(),
            'token' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'PRIMARY KEY(room_id, user_id)',
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
            '{{%fk-room_member-user_id}}',
            '{{%room_member}}',
            'user_id',
            '{{%user}}',
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
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),
            'attempts' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY(room_id, user_id)',
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
            '{{%fk-room_request-user_id}}',
            '{{%room_request}}',
            'user_id',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        // meeting
        $this->dropTable('{{%meeting}}');

        // room_request
        $this->dropForeignKey(
            '{{%fk-room_request-room_id}}',
            '{{%room_request}}'
        );
        $this->dropForeignKey(
            '{{%fk-room_request-user_id}}',
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
            '{{%fk-room_member-user_id}}',
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
