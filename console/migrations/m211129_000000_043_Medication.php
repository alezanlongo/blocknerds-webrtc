<?php

/**
 * Table for Medication
 */
class m211129_000000_043_Medication extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medications}}', [
            'approvedby' => $this->string(),
            'billingndc' => $this->string(),
            'chartsharinggroupid' => $this->integer(),
            'createdby' => $this->string(),
            'deletedby' => $this->string(),
            'earliestfilldate' => $this->string(),
            'encounterid' => $this->integer(),
            'futuresubmitdate' => $this->string(),
            'issafetorenew' => $this->string(),
            'isstructuredsig' => $this->string(),
            'lastupdated' => $this->string(),
            'medication' => $this->string(),
            'medicationentryid' => $this->string(),
            'medicationid' => $this->integer(),
            'ndcoptions' => $this->string(),
            'orderingmode' => $this->string(),
            'organclass' => $this->string(),
            'patientid' => $this->integer(),
            'patientnote' => $this->string(),
            'pharmacy' => $this->string(),
            'pharmacyncpdpid' => $this->string(),
            'prescribedby' => $this->string(),
            'providernote' => $this->string(),
            'refillsallowed' => $this->integer(),
            'route' => $this->string(),
            'rxnorm' => $this->string(),
            'source' => $this->string(),
            'status' => $this->string(),
            'stopreason' => $this->string(),
            'therapeuticclass' => $this->string(),
            'unstructuredsig' => $this->string(),
            'patient_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-patient-patient_id',
            '{{%medications}}',
            'patient_id',
            'patients',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%medications}}');
    }
}
