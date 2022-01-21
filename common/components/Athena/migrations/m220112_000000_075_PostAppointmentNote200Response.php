<?php

/**
 * Table for PostAppointmentNote200Response
 */
class m220112_000000_075_PostAppointmentNote200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_appointment_note200_responses}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_appointment_note200_responses}}');
    }
}