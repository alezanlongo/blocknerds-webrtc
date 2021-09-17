<?php

/**
 * Table for PutAppointment200Response
 */
class m210916_000000_PutAppointment200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_appointment200_responses}}', [
            'appointmentcopay' => $this->string(),
            'appointmentid' => $this->string(),
            'appointmentstatus' => $this->string(),
            'appointmenttype' => $this->string(),
            'appointmenttypeid' => $this->string(),
            'chargeentrynotrequired' => $this->string(),
            'chargeentrynotrequiredreason' => $this->string(),
            'claims' => $this->string(),
            'copay' => $this->string(),
            'date' => $this->string(),
            'departmentid' => $this->string(),
            'duration' => $this->integer(),
            'encounterid' => $this->string(),
            'encounterprep' => $this->string(),
            'encounterstate' => $this->string(),
            'encounterstatus' => $this->string(),
            'frozenyn' => $this->string(),
            'hl7providerid' => $this->integer(),
            'insurances' => $this->string(),
            'patient' => $this->string(),
            'patientappointmenttypename' => $this->string(),
            'patientid' => $this->string(),
            'patientlocationid' => $this->string(),
            'providerid' => $this->string(),
            'referringproviderid' => $this->integer(),
            'renderingproviderid' => $this->integer(),
            'rescheduledappointmentid' => $this->string(),
            'startcheckin' => $this->string(),
            'starttime' => $this->string(),
            'stopcheckin' => $this->string(),
            'supervisingproviderid' => $this->integer(),
            'urgentyn' => $this->string(),
            'useexpectedprocedurecodes' => $this->string(),
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
