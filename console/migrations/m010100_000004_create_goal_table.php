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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%goal}}');
    }
}
