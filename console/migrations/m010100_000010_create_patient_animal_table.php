<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000010_create_patient_animal_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
    }
}
