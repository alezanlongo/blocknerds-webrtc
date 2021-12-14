<?php

/**
 * Table for PrivacyInformationVerified200Response
 */
class m211214_000000_144_PrivacyInformationVerified200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%privacy_information_verified200_responses}}', [
            'patientid' => $this->integer(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%privacy_information_verified200_responses}}');
    }
}
