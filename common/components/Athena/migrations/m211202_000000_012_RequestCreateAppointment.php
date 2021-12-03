<?php

/**
 * Table for RequestCreateAppointment
 */
class m211202_000000_012_RequestCreateAppointment extends \yii\db\Migration
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
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_create_appointments}}');
    }
}
