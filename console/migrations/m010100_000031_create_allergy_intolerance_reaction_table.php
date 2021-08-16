<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000031_create_allergy_intolerance_reaction_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%allergy_intolerance_reaction}}', [
            'id' => $this->primaryKey(),
            'substance__coding' => $this->json(),
            'substance__text' => $this->string(),
            'certainty' => $this->string(),
            'manifestation__coding' => $this->json(),
            'manifestation__text' => $this->string(),
            'description' => $this->string(),
            'onset' => $this->string(),
            'severity' => $this->string(),
            'exposureRoute__coding' => $this->json(),
            'exposureRoute__text' => $this->string(),
            'note__coding' => $this->json(),
            'note__text' => $this->string(),
            'allergy_intolerance_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reaction-allergy_intolerance_id',
            'allergy_intolerance_reaction',
            'allergy_intolerance_id',
            'allergy_intolerance',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%allergy_intolerance_reaction}}');
    }
}
