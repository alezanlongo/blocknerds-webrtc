<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000013_create_care_plan_activity_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan_activity}}', [
            'id' => $this->primaryKey(),
            'progress' => $this->json(),
            'detail' => $this->json(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-activity-care_plan_id',
            'care_plan_activity',
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
        $this->dropTable('{{%care_plan_activity}}');
    }
}
