<?php

/**
 * Table for AppointmentResponse
 */
class m211118_000000_013_AppointmentResponse extends \yii\db\Migration
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
