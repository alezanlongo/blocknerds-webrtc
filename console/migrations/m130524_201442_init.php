<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        // user table
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

        // room table
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');

        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'uuid' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'owner_id' => $this->integer()->notNull(),
            'scheduled_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        // room_member table
        $this->createTable('{{%room_member}}', [
            'room_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'token' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'PRIMARY KEY(room_id, user_id)',
        ]);

        // add foreign key for table `{{%room_member}}`
        $this->addForeignKey(
            '{{%fk-room_member-room_id}}',
            '{{%room_member}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
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

        // room_request table
        $this->createTable('{{%room_request}}', [
            'room_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(2),
            'attempts' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
            'PRIMARY KEY(room_id, user_id)',
        ]);

        // add foreign key for table `{{%room_request}}`
        $this->addForeignKey(
            '{{%fk-room_request-room_id}}',
            '{{%room_request}}',
            'room_id',
            '{{%room}}',
            'id',
            'CASCADE'
        );

        // add foreign key for table `{{%user}}`
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
        // room_request table
        $this->dropForeignKey(
            '{{%fk-room_request-room_id}}',
            '{{%room_request}}'
        );

        $this->dropForeignKey(
            '{{%fk-room_request-user_id}}',
            '{{%room_request}}'
        );

        $this->dropTable('{{%room_request}}');

        // room_member table
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
        $this->dropTable('{{%room}}');
        $this->execute('DROP EXTENSION IF EXISTS "uuid-ossp";');

        // user
        $this->dropTable('{{%user}}');
    }
}
