<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000029_create_immunization_vaccination_protocol_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
        $this->dropTable('{{%immunization_vaccination_protocol}}');
    }
}
