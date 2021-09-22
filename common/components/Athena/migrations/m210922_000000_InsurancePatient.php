<?php

/**
 * Table for InsurancePatient
 */
class m210922_000000_InsurancePatient extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%insurance_patients}}', [
            'adjusterfax' => $this->string(),
            'adjusterfirstname' => $this->string(),
            'adjusterlastname' => $this->string(),
            'adjusterphone' => $this->string(),
            'anotherpartyresponsibleyn' => $this->string(),
            'autoaccidentstate' => $this->string(),
            'cancelled' => $this->string(),
            'caseinjurydate' => $this->string(),
            'casepolicytypename' => $this->string(),
            'ccmstatusid' => $this->integer(),
            'ccmstatusname' => $this->string(),
            'coinsurancepercent' => $this->float(),
            'copays' => $this->string(),
            'descriptionofinjury' => $this->string(),
            'eligibilitylastchecked' => $this->string(),
            'eligibilitymessage' => $this->string(),
            'eligibilityreason' => $this->string(),
            'eligibilitystatus' => $this->string(),
            'employerid' => $this->string(),
            'expirationdate' => $this->string(),
            'icd10codes' => $this->string(),
            'icd9codes' => $this->string(),
            'injuredbodypart' => $this->string(),
            'insuranceclaimnumber' => $this->string(),
            'insuranceid' => $this->string(),
            'insuranceidnumber' => $this->string(),
            'insurancepackageaddress1' => $this->string(),
            'insurancepackageaddress2' => $this->string(),
            'insurancepackagecity' => $this->string(),
            'insurancepackageid' => $this->integer(),
            'insurancepackagestate' => $this->string(),
            'insurancepackagezip' => $this->string(),
            'insurancephone' => $this->string(),
            'insuranceplandisplayname' => $this->string(),
            'insuranceplanname' => $this->string(),
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
            'insurancetype' => $this->string(),
            'insuredentitytypeid' => $this->integer(),
            'insuredpcp' => $this->string(),
            'insuredpcpnpi' => $this->integer(),
            'ircid' => $this->integer(),
            'ircname' => $this->string(),
            'issuedate' => $this->string(),
            'policynumber' => $this->string(),
            'relatedtoautoaccidentyn' => $this->string(),
            'relatedtoemploymentyn' => $this->string(),
            'relatedtootheraccidentyn' => $this->string(),
            'relationshiptoinsured' => $this->string(),
            'relationshiptoinsuredid' => $this->integer(),
            'repricername' => $this->string(),
            'repricerphone' => $this->string(),
            'sequencenumber' => $this->integer(),
            'slidingfeeplanid' => $this->integer(),
            'stateofreportedinjury' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%insurance_patients}}');
    }
}
