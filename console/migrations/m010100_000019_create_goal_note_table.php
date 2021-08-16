<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000019_create_goal_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goal_note}}', [
            'id' => $this->primaryKey(),
            'authorReference' => $this->json(),
            'authorString' => $this->string(),
            'time' => $this->string(),
            'text' => $this->string(),
            'goal_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-note-goal_id',
            'goal_note',
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
        $this->dropTable('{{%goal_note}}');
    }
}
