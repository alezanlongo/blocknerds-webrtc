<?php

/**
 * Table for PostPrivacyInformationVerified
 */
class m220112_000000_145_PostPrivacyInformationVerified extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_privacy_information_verifieds}}', [
            'departmentid' => $this->integer()->notNull(),
            'expirationdate' => $this->string(),
            'insuredsignature' => $this->boolean(),
            'patientsignature' => $this->boolean(),
            'privacynotice' => $this->boolean(),
            'reasonpatientunabletosign' => $this->string(),
            'signaturedatetime' => $this->string()->notNull(),
            'signaturename' => $this->string()->notNull(),
            'signerrelationshiptopatientid' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_privacy_information_verifieds}}');
    }
}
