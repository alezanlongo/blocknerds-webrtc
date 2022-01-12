<?php

/**
 * Table for MedicalHistory
 */
class m220112_000000_146_MedicalHistory extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_histories}}', [
            'patient_id' => $this->integer(),
            'sectionnote' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-patient-patient_id',
            '{{%medical_histories}}',
            'patient_id',
            'patients',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%medical_histories}}');
    }
}
