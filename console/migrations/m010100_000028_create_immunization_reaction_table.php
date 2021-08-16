<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000028_create_immunization_reaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%immunization_reaction}}', [
            'id' => $this->primaryKey(),
            'date' => $this->string(),
            'reported' => $this->boolean(),
            'immunization_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reaction-immunization_id',
            'immunization_reaction',
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
        $this->dropTable('{{%immunization_reaction}}');
    }
}
