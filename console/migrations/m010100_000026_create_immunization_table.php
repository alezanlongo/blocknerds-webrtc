<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000026_create_immunization_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%immunization}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'date' => $this->string(),
            'expiration_date' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'reported' => $this->string(),
            'vaccinecode__coding' => $this->json(),
            'vaccinecode__text' => $this->string(),
            'wasNotGiven' => $this->boolean(),
            'reported' => $this->boolean(),
            'lotNumber' => $this->string(),
            'expirationDate' => $this->string(),
            'site__coding' => $this->json(),
            'site__text' => $this->string(),
            'route__coding' => $this->json(),
            'route__text' => $this->string(),
            'doseQuantity' => $this->json(),
            'explanation__reason' => $this->json(),
            'explanation__reasonNotGiven' => $this->json(),
        ]);

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

        $this->createTable('{{%immunization_vaccination_protocol}}', [
            'id' => $this->primaryKey(),
            'dosSequence' => $this->integer(),
            'description' => $this->string(),
            'series' => $this->string(),
            'seriesDoses' => $this->string(),
            'targetDisease' => $this->json(),
            'doseStatus__coding' => $this->json(),
            'doseStatus__text' => $this->string(),
            'doseStatusReason' => $this->json(),
            'immunization_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-vaccination_protocol-immunization_id',
            'immunization_vaccination_protocol',
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
        $this->dropTable('{{%immunization_vaccination_protocol}}');
        $this->dropTable('{{%immunization_note}}');
        $this->dropTable('{{%immunization}}');
    }
}
