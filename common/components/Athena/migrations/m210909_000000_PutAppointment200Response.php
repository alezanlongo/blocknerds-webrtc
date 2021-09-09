<?php

/**
 * Table for PutAppointment200Response
 */
class m210909_000000_PutAppointment200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_appointment200_responses}}', [
            'appointmentcopay' => text,
            'appointmentid' => text,
            'appointmentstatus' => text,
            'appointmenttype' => text,
            'appointmenttypeid' => text,
            'chargeentrynotrequired' => text,
            'chargeentrynotrequiredreason' => text,
            'claims' => text,
            'copay' => text,
            'date' => text,
            'departmentid' => text,
            'duration' => integer,
            'encounterid' => text,
            'encounterprep' => text,
            'encounterstate' => text,
            'encounterstatus' => text,
            'frozenyn' => text,
            'hl7providerid' => integer,
            'insurances' => text,
            'patient' => text,
            'patientappointmenttypename' => text,
            'patientid' => text,
            'patientlocationid' => text,
            'providerid' => text,
            'referringproviderid' => integer,
            'renderingproviderid' => integer,
            'rescheduledappointmentid' => text,
            'startcheckin' => text,
            'starttime' => text,
            'stopcheckin' => text,
            'supervisingproviderid' => integer,
            'urgentyn' => text,
            'useexpectedprocedurecodes' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%put_appointment200_responses}}');
    }
}
