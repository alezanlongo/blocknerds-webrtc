<?php

/**
 * Table for Appointment
 */
class m210909_000000_Appointment extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%appointments}}', [
            'appointmenttypeid' => integer,
            'bookingnote' => text,
            'departmentid' => integer,
            'donotsendconfirmationemail' => boolean,
            'ignoreschedulablepermission' => boolean,
            'insuranceinfo' => text,
            'nopatientcase' => boolean,
            'patientid' => integer->notNull(),
            'reasonid' => integer,
            'urgentyn' => boolean,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%appointments}}');
    }
}
