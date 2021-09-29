<?php

/**
 * Table for Appointment
 */
class m210929_000000_Appointment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointments}}', [
            'appointmenttypeid' => $this->integer(),
            'bookingnote' => $this->string(),
            'departmentid' => $this->integer(),
            'donotsendconfirmationemail' => $this->boolean(),
            'ignoreschedulablepermission' => $this->boolean(),
            'insuranceinfo' => $this->string(),
            'nopatientcase' => $this->boolean(),
            'patientid' => $this->integer()->notNull(),
            'reasonid' => $this->integer(),
            'urgentyn' => $this->boolean(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%appointments}}');
    }
}
