<?php

/**
 * Table for PrivacyInformationVerified
 */
class m220112_000000_143_PrivacyInformationVerified extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%privacy_information_verifieds}}', [
            'checkboxesconfigured' => $this->integer(),
            'insuredsignature' => $this->string(),
            'patientsignature' => $this->string(),
            'privacynotice' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%privacy_information_verifieds}}');
    }
}
