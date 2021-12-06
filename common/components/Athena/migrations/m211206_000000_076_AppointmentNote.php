<?php

/**
 * Table for AppointmentNote
 */
class m211206_000000_076_AppointmentNote extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointment_notes}}', [
            'created' => $this->string(),
            'createdby' => $this->string(),
            'deleted' => $this->string(),
            'deletedby' => $this->string(),
            'displayonschedule' => $this->string(),
            'lastmodified' => $this->string(),
            'lastmodifiedby' => $this->string(),
            'noteid' => $this->string(),
            'notetext' => $this->string(),
            'put_appointment200_response_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-put_appointment200_response-put_appointment200_response_id',
            '{{%appointment_notes}}',
            'put_appointment200_response_id',
            'put_appointment200_responses',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%appointment_notes}}');
    }
}
