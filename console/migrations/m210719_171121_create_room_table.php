<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%room}}`.
 */
class m210719_171121_create_room_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->execute('CREATE EXTENSION IF NOT EXISTS "uuid-ossp";');
        $this->createTable('{{%room}}', [
            'id' => $this->primaryKey(),
            'uuid' => 'uuid DEFAULT uuid_generate_v4() UNIQUE NOT NULL',
            'owner_id' => $this->integer()->notNull(),
            'scheduled_at' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%room}}');
        $this->execute('DROP EXTENSION IF EXISTS "uuid-ossp";');
    }
}
