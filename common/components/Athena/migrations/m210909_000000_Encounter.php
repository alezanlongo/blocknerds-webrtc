<?php

/**
 * Table for Encounter
 */
class m210909_000000_Encounter extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%encounters}}', [
            'appointmentid' => integer,
            'closeddate' => text,
            'closeduser' => text,
            'departmentid' => integer,
            'diagnoses' => text,
            'encounterdate' => text,
            'encounterid' => integer,
            'encountertype' => text,
            'encountervisitname' => text,
            'lastreopened' => text,
            'lastupdated' => text,
            'patientlocation' => text,
            'patientlocationid' => integer,
            'patientstatus' => text,
            'patientstatusid' => integer,
            'providerfirstname' => text,
            'providerid' => integer,
            'providerlastname' => text,
            'providerphone' => text,
            'stage' => text,
            'status' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%encounters}}');
    }
}
