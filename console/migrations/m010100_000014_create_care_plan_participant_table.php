<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000014_create_care_plan_participant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan_participant}}', [
            'id' => $this->primaryKey(),
            'role' => $this->json(),
            'member__display' => $this->string(),
            'member__reference' => $this->string(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-participant-care_plan_id',
            'care_plan_participant',
            'care_plan_id',
            'care_plan',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%care_plan_participant}}');
    }
}
