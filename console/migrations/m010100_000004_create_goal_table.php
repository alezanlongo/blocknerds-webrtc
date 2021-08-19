<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000004_create_goal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%goal}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'subject__display' => $this->string(),
            'subject__reference' => $this->string(),
            'startDate' => $this->string(),
            'targetDate' => $this->string(),
            'description' => $this->string(),
            'status' => $this->boolean(),
            'statusDate' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
        ]);

        $this->createTable('{{%goal_category}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'goal_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-category-goal_id',
            'goal_category',
            'goal_id',
            'goal',
            'id',
            'CASCADE'
        );

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

        $this->createTable('{{%goal_priority}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'goal_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-priority-goal_id',
            'goal_priority',
            'goal_id',
            'goal',
            'id',
            'CASCADE'
        );

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

        $this->createTable('{{%goal_outcome}}', [
            'id' => $this->primaryKey(),
            'resultCodeableConcept' => $this->json(),
            'resultReference' => $this->json(),
            'goal_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-outcome-goal_id',
            'goal_outcome',
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
        $this->dropTable('{{%goal_outcome}}');
        $this->dropTable('{{%goal_note}}');
        $this->dropTable('{{%goal_priority}}');
        $this->dropTable('{{%goal_status_reason}}');
        $this->dropTable('{{%goal_category}}');
        $this->dropTable('{{%goal}}');
    }
}
