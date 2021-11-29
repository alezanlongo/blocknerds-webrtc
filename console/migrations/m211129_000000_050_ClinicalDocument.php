<?php

/**
 * Table for ClinicalDocument
 */
class m211129_000000_050_ClinicalDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_documents}}', [
            'patientid' => $this->integer(),
            'actionnote' => $this->string(),
            'assignedto' => $this->string(),
            'clinicaldocumentid' => $this->integer(),
            'clinicalproviderid' => $this->integer(),
            'createddate' => $this->string(),
            'createddatetime' => $this->string(),
            'createduser' => $this->string(),
            'departmentid' => $this->string(),
            'documentclass' => $this->string(),
            'documentdata' => $this->string(),
            'documentdescription' => $this->string(),
            'documentroute' => $this->string(),
            'documentsource' => $this->string(),
            'documentsubclass' => $this->string(),
            'documenttypeid' => $this->integer(),
            'externalnote' => $this->string(),
            'internalnote' => $this->string(),
            'lastmodifieddate' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'lastmodifieduser' => $this->string(),
            'observationdate' => $this->string(),
            'ordertype' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'providerusername' => $this->string(),
            'status' => $this->string(),
            'tietoorderid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%clinical_documents}}');
    }
}
