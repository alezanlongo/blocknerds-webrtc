<?php

/**
 * Table for PatientStatus
 */
class m210927_000000_PatientStatus extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_statuses}}', [
            'patientstatusname' => $this->string(),
            'patientstatusid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_statuses}}');
    }
}
