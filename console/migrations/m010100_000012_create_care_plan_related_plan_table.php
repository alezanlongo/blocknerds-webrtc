<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000012_create_care_plan_related_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan_related_plan}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'plan' => $this->json(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-related_plan-care_plan_id',
            'care_plan_related_plan',
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
        $this->dropTable('{{%care_plan_related_plan}}');
    }
}
