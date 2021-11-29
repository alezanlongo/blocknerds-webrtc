<?php

/**
 * Table for PutInsurance
 */
class m211129_000000_103_PutInsurance extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_insurances}}', [
            'adjusterfax' => $this->string(),
            'adjusterfirstname' => $this->string(),
            'adjusterlastname' => $this->string(),
            'adjusterphone' => $this->string(),
            'anotherpartyresponsible' => $this->boolean(),
            'autoaccidentstate' => $this->string(),
            'caseinjurydate' => $this->string(),
            'departmentid' => $this->integer(),
            'descriptionofinjury' => $this->string(),
            'expirationdate' => $this->string(),
            'icd10codes' => $this->string(),
            'icd9codes' => $this->string(),
            'injuredbodypart' => $this->string(),
            'insuranceclaimnumber' => $this->string(),
            'insuranceidnumber' => $this->string(),
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
            'newsequencenumber' => $this->integer(),
            'policynumber' => $this->string(),
            'realtedtoautoaccident' => $this->boolean(),
            'relatedtoemployment' => $this->boolean(),
            'relatedtootheraccident' => $this->boolean(),
            'relationshiptoinsuredid' => $this->integer(),
            'repricername' => $this->string(),
            'repricerphone' => $this->string(),
            'stateofreportedinjury' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_insurances}}');
    }
}
