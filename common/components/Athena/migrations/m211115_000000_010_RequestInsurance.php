<?php

/**
 * Table for RequestInsurance
 */
class m211115_000000_010_RequestInsurance extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_insurances}}', [
            'departmentid' => $this->integer(),
            'expirationdate' => $this->string(),
            'insuranceidnumber' => $this->string(),
            'insurancepackageid' => $this->integer()->notNull(),
            'insurancephone' => $this->string(),
            'insurancepolicyholder' => $this->string(),
            'insurancepolicyholderaddress1' => $this->string(),
            'insurancepolicyholderaddress2' => $this->string(),
            'insurancepolicyholdercity' => $this->string(),
            'insurancepolicyholdercountrycode' => $this->string(),
            'insurancepolicyholdercountryiso3166' => $this->string(),
            'insurancepolicyholderdob' => $this->string(),
            'insurancepolicyholderfirstname' => $this->string(),
            'insurancepolicyholderlastname' => $this->string(),
            'insurancepolicyholdermiddlename' => $this->string(),
            'insurancepolicyholdersex' => $this->string(),
            'insurancepolicyholderssn' => $this->string(),
            'insurancepolicyholderstate' => $this->string(),
            'insurancepolicyholdersuffix' => $this->string(),
            'insurancepolicyholderzip' => $this->string(),
            'insuredentitytypeid' => $this->string(),
            'issuedate' => $this->string(),
            'policynumber' => $this->string(),
            'relationshiptoinsuredid' => $this->integer(),
            'sequencenumber' => $this->integer(),
            'updateappointments' => $this->boolean(),
            'validateinsuranceidnumber' => $this->boolean(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_insurances}}');
    }
}
