<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000020_create_goal_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
    }
}
