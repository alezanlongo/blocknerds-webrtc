<?php

/**
 * Table for Appointments
 */
class m210924_000000_Appointments extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointments}}', [
            'appointmentids' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%appointments}}');
    }
}
