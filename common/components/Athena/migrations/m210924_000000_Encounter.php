<?php

/**
 * Table for Encounter
 */
class m210924_000000_Encounter extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%encounters}}', [
            'appointmentid' => $this->integer(),
            'closeddate' => $this->string(),
            'closeduser' => $this->string(),
            'departmentid' => $this->integer(),
            'encounterdate' => $this->string(),
            'encounterid' => $this->integer(),
            'encountertype' => $this->string(),
            'encountervisitname' => $this->string(),
            'lastreopened' => $this->string(),
            'lastupdated' => $this->string(),
            'patientlocation' => $this->string(),
            'patientlocationid' => $this->integer(),
            'patientstatus' => $this->string(),
            'patientstatusid' => $this->integer(),
            'providerfirstname' => $this->string(),
            'providerid' => $this->integer(),
            'providerlastname' => $this->string(),
            'providerphone' => $this->string(),
            'stage' => $this->string(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%encounters}}');
    }
}
