<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000011_create_care_plan_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan_category}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-category-care_plan_id',
            'care_plan_category',
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
        $this->dropTable('{{%care_plan_category}}');
    }
}
