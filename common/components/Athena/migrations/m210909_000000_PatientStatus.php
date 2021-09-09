<?php

/**
 * Table for PatientStatus
 */
class m210909_000000_PatientStatus extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_statuses}}', [
            'patientstatusname' => text,
            'patientstatusid' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%patient_statuses}}');
    }
}
