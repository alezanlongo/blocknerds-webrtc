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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%care_plan}}');
    }
}
