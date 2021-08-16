<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000007_create_patient_contact_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient_contact}}', [
            'id' => $this->primaryKey(),
            'relationship__coding' => $this->json(),
            'relationship__text' => $this->string(),
            'name__use' => $this->string(),
            'name__family' => $this->string(),
            'name__given' => $this->string(),
            'telecom' => $this->json(),
            'address__use' => $this->string(),
            'address__type' => $this->string(),
            'address__text' => $this->string(),
            'address__line' => $this->string(),
            'address__city' => $this->string(),
            'address__district' => $this->string(),
            'address__state' => $this->string(),
            'address__postalCode' => $this->string(),
            'address__country' => $this->string(),
            'gender' => $this->string(),
            'organization__reference' => $this->string(),
            'organization__display' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_contact-patient_id',
            'patient_contact',
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
        $this->dropTable('{{%patient_contact}}');
    }
}
