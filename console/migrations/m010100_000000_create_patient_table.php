<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000000_create_patient_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%patient}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'active' => $this->boolean(),
            'name__family' => $this->string(),
            'name__given' => $this->string(),
            'name__use' => $this->string(),
            'telecom__system' => $this->string(),
            'telecom__use' => $this->string(),
            'telecom__value' => $this->string(),
            'gender' => $this->string(),
            'birthDate' => $this->string(),
            'deceasedBoolean' => $this->boolean(),
            'deceasedDateTime' => $this->string(),
            'multipleBirthBoolean' => $this->boolean(),
            'multipleBirthInteger' => $this->integer(),
        ]);

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

        $this->createTable('{{%patient_photo}}', [
            'id' => $this->primaryKey(),
            'contentType' => $this->string(),
            'language' => $this->string(),
            'data' => $this->string(),
            'uri' => $this->string(),
            'size' => $this->integer()->unsigned(),
            'hash' => $this->string(),
            'title' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_photo-patient_id',
            'patient_photo',
            'patient_id',
            'patient',
            'id',
            'CASCADE'
        );

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

        $this->createTable('{{%patient_communication}}', [
            'id' => $this->primaryKey(),
            'language__coding' => $this->json(),
            'language__text' => $this->string(),
            'prefered' => $this->boolean(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_communication-patient_id',
            'patient_communication',
            'patient_id',
            'patient',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%patient_link}}', [
            'id' => $this->primaryKey(),
            'type' => $this->string(),
            'other__display' => $this->string(),
            'other__reference' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_link-patient_id',
            'patient_link',
            'patient_id',
            'patient',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%patient_animal}}', [
            'id' => $this->primaryKey(),
            'species__coding' => $this->json(),
            'species__text' => $this->string(),
            'breed__coding' => $this->json(),
            'breed__text' => $this->string(),
            'genderStatus__coding' => $this->json(),
            'genderStatus__text' => $this->string(),
            'patient_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-patient_animal-patient_id',
            'patient_animal',
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
        $this->dropTable('{{%patient_animal}}');
        $this->dropTable('{{%patient_link}}');
        $this->dropTable('{{%patient_communication}}');
        $this->dropTable('{{%patient_contact}}');
        $this->dropTable('{{%patient_photo}}');
        $this->dropTable('{{%patient_address}}');
        $this->dropTable('{{%patient}}');
    }
}
