<?php

/**
 * Table for AppointmentResponse
 */
class m220112_000000_011_AppointmentResponse extends \yii\db\Migration
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