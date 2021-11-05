<?php

/**
 * Table for AppointmentChanged
 */
class m211105_000000_029_AppointmentChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointment_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%appointment_changeds}}');
    }
}
