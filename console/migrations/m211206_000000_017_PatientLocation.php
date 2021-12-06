<?php

/**
 * Table for PatientLocation
 */
class m211206_000000_017_PatientLocation extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_locations}}', [
            'defaultoncheckin' => $this->string(),
            'name' => $this->string(),
            'patientlocationid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patient_locations}}');
    }
}