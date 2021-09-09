<?php

/**
 * Table for InsurancePatient
 */
class m210909_000000_InsurancePatient extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_patients}}', [
            'adjusterfax' => text,
            'adjusterfirstname' => text,
            'adjusterlastname' => text,
            'adjusterphone' => text,
            'anotherpartyresponsibleyn' => text,
            'autoaccidentstate' => text,
            'cancelled' => text,
            'caseinjurydate' => text,
            'casepolicytypename' => text,
            'ccmstatusid' => integer,
            'ccmstatusname' => text,
            'coinsurancepercent' => float,
            'copays' => text,
            'descriptionofinjury' => text,
            'eligibilitylastchecked' => text,
            'eligibilitymessage' => text,
            'eligibilityreason' => text,
            'eligibilitystatus' => text,
            'employerid' => text,
            'expirationdate' => text,
            'icd10codes' => text,
            'icd9codes' => text,
            'injuredbodypart' => text,
            'insuranceclaimnumber' => text,
            'insuranceid' => text,
            'insuranceidnumber' => text,
            'insurancepackageaddress1' => text,
            'insurancepackageaddress2' => text,
            'insurancepackagecity' => text,
            'insurancepackageid' => integer,
            'insurancepackagestate' => text,
            'insurancepackagezip' => text,
            'insurancephone' => text,
            'insuranceplandisplayname' => text,
            'insuranceplanname' => text,
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
            'insurancetype' => text,
            'insuredentitytypeid' => integer,
            'insuredpcp' => text,
            'insuredpcpnpi' => integer,
            'ircid' => integer,
            'ircname' => text,
            'issuedate' => text,
            'policynumber' => text,
            'relatedtoautoaccidentyn' => text,
            'relatedtoemploymentyn' => text,
            'relatedtootheraccidentyn' => text,
            'relationshiptoinsured' => text,
            'relationshiptoinsuredid' => integer,
            'repricername' => text,
            'repricerphone' => text,
            'sequencenumber' => integer,
            'slidingfeeplanid' => integer,
            'stateofreportedinjury' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%insurance_patients}}');
    }
}
