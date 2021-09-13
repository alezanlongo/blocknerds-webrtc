<?php

/**
 * Table for PatientLocation
 */
class m210909_000000_PatientLocation extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patient_locations}}', [
            'defaultoncheckin' => text,
            'name' => text,
            'patientlocationid' => integer,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%patient_locations}}');
    }
}
