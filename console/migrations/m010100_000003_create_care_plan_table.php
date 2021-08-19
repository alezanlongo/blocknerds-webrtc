<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000003_create_care_plan_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%care_plan}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'subject__display' => $this->string(),
            'subject__reference' => $this->string(),
            'status' => $this->boolean(),
            'period__start' => $this->string(),
            'period__end' => $this->string(),
            'modified' => $this->string(),
            'description' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
        ]);

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

        $this->createTable('{{%care_plan_note}}', [
            'id' => $this->primaryKey(),
            'note__authorReference' => $this->string(),
            'note__authorString' => $this->string(),
            'note__time' => $this->string(),
            'note__text' => $this->string(),
            'care_plan_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-note-care_plan_id',
            'care_plan_note',
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
        $this->dropTable('{{%care_plan_related_plan}}');
        $this->dropTable('{{%care_plan_activity}}');
        $this->dropTable('{{%care_plan_participant}}');
        $this->dropTable('{{%care_plan_note}}');
        $this->dropTable('{{%care_plan}}');
    }
}
