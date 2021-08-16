<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000017_create_goal_status_reason_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goal_status_reason}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'goal_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-status_reason-goal_id',
            'goal_status_reason',
            'goal_id',
            'goal',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%goal_status_reason}}');
    }
}
