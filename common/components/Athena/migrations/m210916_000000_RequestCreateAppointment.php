<?php

/**
 * Table for RequestCreateAppointment
 */
class m210916_000000_RequestCreateAppointment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_create_appointments}}', [
            'appointmentdate' => $this->string()->notNull(),
            'appointmenttime' => $this->string()->notNull(),
            'appointmenttypeid' => $this->integer(),
            'departmentid' => $this->integer()->notNull(),
            'providerid' => $this->integer()->notNull(),
            'reasonid' => $this->integer(),
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
