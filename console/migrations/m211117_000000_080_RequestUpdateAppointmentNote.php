<?php

/**
 * Table for RequestUpdateAppointmentNote
 */
class m211117_000000_080_RequestUpdateAppointmentNote extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_update_appointment_notes}}', [
            'displayonschedule' => $this->boolean(),
            'notetext' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_update_appointment_notes}}');
    }
}
