<?php

/**
 * Table for Appointments
 */
class m210927_000000_Appointments extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointments}}', [
            'appointmentids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%appointments}}');
    }
}
