<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000001_create_patient_address_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient_address}}', [
            'id' => $this->primaryKey(),
            'city' => $this->string(),
            'country' => $this->string(),
            'district' => $this->string(),
            'line' => $this->string(),
            'period' => $this->string(),
            'postalcode' => $this->string(),
            'state' => $this->string(),
            'text' => $this->string(),
            'type' => $this->string(),
            'use' => $this->string(),
            'maritalStatus__text' => $this->string(),
            'maritalStatus__coding' => $this->json(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_address-patient_id',
            'patient_address',
            'patient_id',
            'patient',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%patient_address}}');
    }
}
