<?php

/**
 * Table for PostPatientCase200Response
 */
class m211005_000000_024_PostPatientCase200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_patient_case200_responses}}', [
            'errormessage' => $this->string(),
            'patientcaseid' => $this->integer(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_patient_case200_responses}}');
    }
}
