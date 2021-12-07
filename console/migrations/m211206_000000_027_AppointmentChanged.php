<?php

/**
 * Table for AppointmentChanged
 */
class m211206_000000_027_AppointmentChanged extends \yii\db\Migration
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
