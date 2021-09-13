<?php

/**
 * Table for RequestCreateAppointment
 */
class m210909_000000_RequestCreateAppointment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_appointments}}', [
            'appointmentdate' => text->notNull(),
            'appointmenttime' => text->notNull(),
            'appointmenttypeid' => integer,
            'departmentid' => integer->notNull(),
            'providerid' => integer->notNull(),
            'reasonid' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%request_create_appointments}}');
    }
}
