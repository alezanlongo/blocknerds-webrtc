<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000027_create_immunization_note_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%immunization_note}}', [
            'id' => $this->primaryKey(),
            'authorReference' => $this->json(),
            'authorString' => $this->string(),
            'time' => $this->string(),
            'text' => $this->string(),
            'immunization_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-note-immunization_id',
            'immunization_note',
            'immunization_id',
            'immunization',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%immunization_note}}');
    }
}
