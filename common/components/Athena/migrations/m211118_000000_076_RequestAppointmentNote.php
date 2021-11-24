<?php

/**
 * Table for RequestAppointmentNote
 */
class m211118_000000_076_RequestAppointmentNote extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_appointment_notes}}', [
            'displayonschedule' => $this->boolean(),
            'notetext' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_appointment_notes}}');
    }
}
