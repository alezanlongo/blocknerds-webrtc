<?php

/**
 * Table for PatientStatus
 */
class m210925_000000_PatientStatus extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_statuses}}', [
            'patientstatusname' => $this->string(),
            'patientstatusid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%patient_statuses}}');
    }
}
