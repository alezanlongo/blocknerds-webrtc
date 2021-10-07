<?php

/**
 * Table for Patient
 */
class m211005_000000_001_Patient extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%patients}}', [
            'address1' => $this->string(),
            'address2' => $this->string(),
            'agriculturalworker' => $this->string(),
            'agriculturalworkertype' => $this->string(),
            'caresummarydeliverypreference' => $this->string(),
            'city' => $this->string(),
            'claimbalancedetails' => $this->string(),
            'confidentialitycode' => $this->string(),
            'consenttocall' => $this->string(),
            'consenttotext' => $this->string(),
            'contacthomephone' => $this->string(),
            'contactmobilephone' => $this->string(),
            'contactname' => $this->string(),
            'contactpreference' => $this->string(),
            'contactpreference_announcement_email' => $this->string(),
            'contactpreference_announcement_phone' => $this->string(),
            'contactpreference_announcement_sms' => $this->string(),
            'contactpreference_appointment_email' => $this->string(),
            'contactpreference_appointment_phone' => $this->string(),
            'contactpreference_appointment_sms' => $this->string(),
            'contactpreference_billing_email' => $this->string(),
            'contactpreference_billing_phone' => $this->string(),
            'contactpreference_billing_sms' => $this->string(),
            'contactpreference_lab_email' => $this->string(),
            'contactpreference_lab_phone' => $this->string(),
            'contactpreference_lab_sms' => $this->string(),
            'contactrelationship' => $this->string(),
            'countrycode' => $this->string(),
            'countrycode3166' => $this->string(),
            'deceaseddate' => $this->string(),
            'defaultpharmacyncpdpid' => $this->string(),
            'departmentid' => $this->string()->notNull(),
            'dob' => $this->string()->notNull(),
            'donotcallyn' => $this->string(),
            'driverslicenseexpirationdate' => $this->string(),
            'driverslicensenumber' => $this->string(),
            'driverslicensestateid' => $this->string(),
            'driverslicenseurl' => $this->string(),
            'driverslicenseyn' => $this->string(),
            'email' => $this->string()->notNull(),
            'emailexistsyn' => $this->string(),
            'employeraddress' => $this->string(),
            'employercity' => $this->string(),
            'employerfax' => $this->string(),
            'employerid' => $this->string(),
            'employername' => $this->string(),
            'employerphone' => $this->string(),
            'employerstate' => $this->string(),
            'employerzip' => $this->string(),
            'ethnicitycode' => $this->string(),
            'firstappointment' => $this->string(),
            'firstname' => $this->string()->notNull(),
            'guarantoraddress1' => $this->string(),
            'guarantoraddress2' => $this->string(),
            'guarantoraddresssameaspatient' => $this->string(),
            'guarantorcity' => $this->string(),
            'guarantorcountrycode' => $this->string(),
            'guarantorcountrycode3166' => $this->string(),
            'guarantordob' => $this->string(),
            'guarantoremail' => $this->string(),
            'guarantoremployerid' => $this->string(),
            'guarantorfirstname' => $this->string(),
            'guarantorlastname' => $this->string(),
            'guarantormiddlename' => $this->string(),
            'guarantorphone' => $this->string(),
            'guarantorrelationshiptopatient' => $this->string(),
            'guarantorssn' => $this->string(),
            'guarantorstate' => $this->string(),
            'guarantorsuffix' => $this->string(),
            'guarantorzip' => $this->string(),
            'guardianfirstname' => $this->string(),
            'guardianlastname' => $this->string(),
            'guardianmiddlename' => $this->string(),
            'guardiansuffix' => $this->string(),
            'hasmobileyn' => $this->string(),
            'hierarchicalcode' => $this->string(),
            'homeboundyn' => $this->string(),
            'homeless' => $this->string(),
            'homelesstype' => $this->string(),
            'homephone' => $this->string(),
            'industrycode' => $this->string(),
            'language6392code' => $this->string(),
            'lastappointment' => $this->string(),
            'lastemail' => $this->string(),
            'lastname' => $this->string()->notNull(),
            'maritalstatus' => $this->string(),
            'maritalstatusname' => $this->string(),
            'medicationhistoryconsentverified' => $this->string(),
            'middlename' => $this->string(),
            'mobilecarrierid' => $this->string(),
            'mobilephone' => $this->string(),
            'nextkinname' => $this->string(),
            'nextkinphone' => $this->string(),
            'nextkinrelationship' => $this->string(),
            'notes' => $this->string(),
            'occupationcode' => $this->string(),
            'onlinestatementonlyyn' => $this->string(),
            'patientid' => $this->string(),
            'patientphotourl' => $this->string(),
            'patientphotoyn' => $this->string(),
            'portalaccessgiven' => $this->string(),
            'portalsignatureonfile' => $this->string(),
            'portalstatus' => $this->string(),
            'portaltermsonfile' => $this->string(),
            'povertylevelcalculated' => $this->string(),
            'povertylevelfamilysize' => $this->string(),
            'povertylevelfamilysizedeclined' => $this->string(),
            'povertylevelincomedeclined' => $this->string(),
            'povertylevelincomepayperiod' => $this->string(),
            'povertylevelincomeperpayperiod' => $this->string(),
            'povertylevelincomerangedeclined' => $this->string(),
            'preferredname' => $this->string(),
            'primarydepartmentid' => $this->string(),
            'primaryproviderid' => $this->string(),
            'privacyinformationverified' => $this->string(),
            'publichousing' => $this->string(),
            'race' => $this->string(),
            'racename' => $this->string(),
            'referralsourceid' => $this->string(),
            'registrationdate' => $this->string(),
            'schoolbasedhealthcenter' => $this->string(),
            'sex' => $this->string(),
            'ssn' => $this->string(),
            'state' => $this->string(),
            'status' => $this->string(),
            'suffix' => $this->string(),
            'veteran' => $this->string(),
            'workphone' => $this->string(),
            'zip' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%patients}}');
    }
}
