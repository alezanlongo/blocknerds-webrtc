<?php

/**
 * Table for LabResult
 */
class m211115_000000_071_LabResult extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%lab_results}}', [
            'actionnote' => $this->string(),
            'alarmdays' => $this->string(),
            'appointmentid' => $this->integer(),
            'assignedto' => $this->string(),
            'createddate' => $this->string(),
            'createddatetime' => $this->string(),
            'createduser' => $this->string(),
            'deleteddatetime' => $this->string(),
            'departmentid' => $this->string(),
            'description' => $this->string(),
            'documentclass' => $this->string(),
            'documentroute' => $this->string(),
            'documentsource' => $this->string(),
            'documentsubclass' => $this->string(),
            'documenttypeid' => $this->integer(),
            'encounterdate' => $this->string(),
            'encounterid' => $this->string(),
            'externalaccessionid' => $this->string(),
            'externalnoteonly' => $this->string(),
            'facilityid' => $this->integer(),
            'internalaccessionid' => $this->string(),
            'internalnote' => $this->string(),
            'interpretation' => $this->string(),
            'interpretationtemplate' => $this->string(),
            'isconfidential' => $this->string(),
            'labresultid' => $this->integer(),
            'labresultloinc' => $this->string(),
            'lastmodifieddate' => $this->string(),
            'lastmodifieddatetime' => $this->string(),
            'lastmodifieduser' => $this->string(),
            'notefromlab' => $this->string(),
            'observationdate' => $this->string(),
            'observationdatetime' => $this->string(),
            'ordertype' => $this->string(),
            'patientnote' => $this->string(),
            'performinglabaddress1' => $this->string(),
            'performinglabaddress2' => $this->string(),
            'performinglabcity' => $this->string(),
            'performinglabname' => $this->string(),
            'performinglabstate' => $this->string(),
            'performinglabzip' => $this->string(),
            'portalpublisheddatetime' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'providerusername' => $this->string(),
            'receivedfacilityordercode' => $this->string(),
            'reportstatus' => $this->string(),
            'resultcategory' => $this->string(),
            'resultnotes' => $this->string(),
            'resultstatus' => $this->string(),
            'status' => $this->string(),
            'subject' => $this->string(),
            'tietoorderid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%lab_results}}');
    }
}
