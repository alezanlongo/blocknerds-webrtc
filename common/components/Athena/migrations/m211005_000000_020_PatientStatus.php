<?php

/**
 * Table for PatientStatus
 */
class m211005_000000_020_PatientStatus extends \yii\db\Migration
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
