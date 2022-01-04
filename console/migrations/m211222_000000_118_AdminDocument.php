<?php

/**
 * Table for AdminDocument
 */
class m211222_000000_118_AdminDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%admin_documents}}', [
            'actionnote' => $this->string(),
            'adminid' => $this->integer(),
            'appointmentid' => $this->integer(),
            'assignedto' => $this->string(),
            'clinicalproviderid' => $this->integer(),
            'createddate' => $this->string(),
            'createddatetime' => $this->string(),
            'createduser' => $this->string(),
            'deleteddatetime' => $this->string(),
            'departmentid' => $this->string(),
            'description' => $this->string(),
            'documentclass' => $this->string(),
            'documentdata' => $this->string(),
            'documentdate' => $this->string(),
            'documentroute' => $this->string(),
            'documentsource' => $this->string(),
            'documentsubclass' => $this->string(),
            'documenttypeid' => $this->integer(),
            'encounterid' => $this->string(),
            'entitytype' => $this->string(),
            'externalaccessionid' => $this->string(),
            'externalnote' => $this->string(),
            'internalaccessionid' => $this->string(),
            'internalnote' => $this->string(),
            'lastmodifieddate' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'lastmodifieduser' => $this->string(),
            'originaldocument' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'providerusername' => $this->string(),
            'patientid' => $this->integer(),
            'status' => $this->string(),
            'subject' => $this->string(),
            'tietoorderid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%admin_documents}}');
    }
}
