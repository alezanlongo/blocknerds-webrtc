<?php

/**
 * Table for PatientCase
 */
class m220112_000000_023_PatientCase extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_cases}}', [
            'actionnote' => $this->string(),
            'assignedto' => $this->string(),
            'callbackname' => $this->string(),
            'callbacknumber' => $this->string(),
            'callbacknumbertype' => $this->string(),
            'calltype' => $this->string(),
            'clinicalproviderid' => $this->integer(),
            'createddate' => $this->string(),
            'createddatetime' => $this->string(),
            'createddocuments' => $this->string(),
            'createduser' => $this->string(),
            'deleteddatetime' => $this->string(),
            'departmentid' => $this->string(),
            'description' => $this->string(),
            'documentclass' => $this->string(),
            'documentdescription' => $this->string(),
            'documentroute' => $this->string(),
            'documentsource' => $this->string(),
            'documentsubclass' => $this->string(),
            'documenttypeid' => $this->integer(),
            'encounterid' => $this->string(),
            'externalaccessionid' => $this->string(),
            'externalnote' => $this->string(),
            'facilityid' => $this->integer(),
            'internalaccessionid' => $this->string(),
            'internalnote' => $this->string(),
            'lastmodifieddate' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'lastmodifieduser' => $this->string(),
            'observationdatetime' => $this->string(),
            'outboundonly' => $this->string(),
            'patientcaseid' => $this->string(),
            'patientid' => $this->integer(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'providerusername' => $this->string(),
            'status' => $this->string(),
            'subject' => $this->string(),
            'tietoorderid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_cases}}');
    }
}
