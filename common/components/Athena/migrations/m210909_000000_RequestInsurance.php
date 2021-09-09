<?php

/**
 * Table for RequestInsurance
 */
class m210909_000000_RequestInsurance extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_insurances}}', [
            'departmentid' => integer,
            'expirationdate' => text,
            'insuranceidnumber' => text,
            'insurancepackageid' => integer->notNull(),
            'insurancephone' => text,
            'insurancepolicyholder' => text,
            'insurancepolicyholderaddress1' => text,
            'insurancepolicyholderaddress2' => text,
            'insurancepolicyholdercity' => text,
            'insurancepolicyholdercountrycode' => text,
            'insurancepolicyholdercountryiso3166' => text,
            'insurancepolicyholderdob' => text,
            'insurancepolicyholderfirstname' => text,
            'insurancepolicyholderlastname' => text,
            'insurancepolicyholdermiddlename' => text,
            'insurancepolicyholdersex' => text,
            'insurancepolicyholderssn' => text,
            'insurancepolicyholderstate' => text,
            'insurancepolicyholdersuffix' => text,
            'insurancepolicyholderzip' => text,
            'insuredentitytypeid' => text,
            'issuedate' => text,
            'policynumber' => text,
            'relationshiptoinsuredid' => integer,
            'sequencenumber' => integer,
            'updateappointments' => boolean,
            'validateinsuranceidnumber' => boolean,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%request_insurances}}');
    }
}
