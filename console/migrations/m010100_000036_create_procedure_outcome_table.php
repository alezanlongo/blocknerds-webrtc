<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000036_create_procedure_outcome_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure_outcome}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-outcome-procedure_id',
            'procedure_outcome',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%procedure_outcome}}');
    }
}
