<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000039_create_procedure_notes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure_notes}}', [
            'id' => $this->primaryKey(),
            'authorReference' => $this->json(),
            'authorString' => $this->string(),
            'time' => $this->string(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-notes-procedure_id',
            'procedure_notes',
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
        $this->dropTable('{{%procedure_notes}}');
    }
}
