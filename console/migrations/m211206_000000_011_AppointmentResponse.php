<?php

/**
 * Table for AppointmentResponse
 */
class m211206_000000_011_AppointmentResponse extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointment_responses}}', [
            'appointmentids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%appointment_responses}}');
    }
}
