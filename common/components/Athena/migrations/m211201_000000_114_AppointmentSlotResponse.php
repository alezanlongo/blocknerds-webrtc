<?php

/**
 * Table for AppointmentSlotResponse
 */
class m211201_000000_114_AppointmentSlotResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointment_slot_responses}}', [
            'appointmentid' => $this->integer(),
            'appointmenttype' => $this->string(),
            'appointmenttypeid' => $this->integer(),
            'date' => $this->string(),
            'departmentid' => $this->integer(),
            'duration' => $this->integer(),
            'frozenyn' => $this->string(),
            'localproviderid' => $this->integer(),
            'patientappointmenttypename' => $this->string(),
            'providerid' => $this->integer(),
            'reasonid' => $this->integer(),
            'renderingproviderid' => $this->integer(),
            'starttime' => $this->string(),
            'validappointmenttypeids' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%appointment_slot_responses}}');
    }
}
