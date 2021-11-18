<?php

/**
 * Table for PutAppointmentNote200Response
 */
class m211117_000000_081_PutAppointmentNote200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_appointment_note200_responses}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_appointment_note200_responses}}');
    }
}
