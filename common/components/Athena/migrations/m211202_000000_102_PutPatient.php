<?php

/**
 * Table for PutPatient
 */
class m211202_000000_102_PutPatient extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_patients}}', [
            'PATIENTFACINGCALL' => $this->boolean(),
            'THIRDPARTYUSERNAME' => $this->string(),
            'address1' => $this->string(),
            'address2' => $this->string(),
            'agriculturalworker' => $this->string(),
            'agriculturalworkertype' => $this->string(),
            'altfirstname' => $this->string(),
            'assignedsexatbirth' => $this->string(),
            'caresummarydeliverypreference' => $this->string(),
            'city' => $this->string(),
            'clinicalordertypegroupid' => $this->string(),
            'consenttocall' => $this->boolean(),
            'consenttotext' => $this->boolean(),
            'contacthomephone' => $this->string(),
            'contactmobilephone' => $this->string(),
            'contactname' => $this->string(),
            'contactpreference' => $this->string(),
            'contactpreference_announcement_email' => $this->boolean(),
            'contactpreference_announcement_phone' => $this->boolean(),
            'contactpreference_announcement_sms' => $this->boolean(),
            'contactpreference_appointment_email' => $this->boolean(),
            'contactpreference_appointment_phone' => $this->boolean(),
            'contactpreference_appointment_sms' => $this->boolean(),
            'contactpreference_billing_email' => $this->boolean(),
            'contactpreference_billing_phone' => $this->boolean(),
            'contactpreference_billing_sms' => $this->boolean(),
            'contactpreference_lab_email' => $this->boolean(),
            'contactpreference_lab_phone' => $this->boolean(),
            'contactpreference_lab_sms' => $this->boolean(),
            'contactrelationship' => $this->string(),
            'countrycode3166' => $this->string(),
            'deceaseddate' => $this->string(),
            'defaultpharmacyncpdpid' => $this->string(),
            'departmentid' => $this->integer(),
            'dob' => $this->string(),
            'donotcallyn' => $this->boolean(),
            'driverslicenseexpirationdate' => $this->string(),
            'driverslicensenumber' => $this->string(),
            'driverslicensestateid' => $this->string(),
            'email' => $this->string(),
            'employerid' => $this->integer(),
            'employerphone' => $this->string(),
            'ethnicitycode' => $this->string(),
            'firstname' => $this->string(),
            'genderidentity' => $this->string(),
            'genderidentityother' => $this->string(),
            'guarantoraddress1' => $this->string(),
            'guarantoraddress2' => $this->string(),
            'guarantoraddresssameaspatient' => $this->boolean(),
            'guarantorcity' => $this->string(),
            'guarantorcountrycode3166' => $this->string(),
            'guarantordob' => $this->string(),
            'guarantoremail' => $this->string(),
            'guarantoremployerid' => $this->integer(),
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
            'hasmobileyn' => $this->boolean(),
            'homeboundyn' => $this->boolean(),
            'homeless' => $this->string(),
            'homelesstype' => $this->string(),
            'homephone' => $this->string(),
            'ignorerestrictions' => $this->boolean(),
            'industrycode' => $this->string(),
            'language6392code' => $this->string(),
            'lastname' => $this->string(),
            'lookupdepartmentid' => $this->integer(),
            'maritalstatus' => $this->string(),
            'middlename' => $this->string(),
            'mobilecarrierid' => $this->string(),
            'mobilephone' => $this->string(),
            'nextkinname' => $this->string(),
            'nextkinphone' => $this->string(),
            'nextkinrelationship' => $this->string(),
            'notes' => $this->string(),
            'occupationcode' => $this->string(),
            'onlinestatementonlyyn' => $this->boolean(),
            'portalaccessgiven' => $this->boolean(),
            'povertylevelcalculated' => $this->float(),
            'povertylevelfamilysize' => $this->float(),
            'povertylevelfamilysizedeclined' => $this->boolean(),
            'povertylevelincomedeclined' => $this->boolean(),
            'povertylevelincomepayperiod' => $this->string(),
            'povertylevelincomeperpayperiod' => $this->integer(),
            'povertylevelincomerangedeclined' => $this->boolean(),
            'preferredname' => $this->string(),
            'preferredpronouns' => $this->string(),
            'primarydepartmentid' => $this->string(),
            'primaryproviderid' => $this->string(),
            'publichousing' => $this->string(),
            'race' => $this->string(),
            'referralsourceid' => $this->string(),
            'referralsourceother' => $this->string(),
            'registerpatientindepartment' => $this->boolean(),
            'returnerroroninvalidemail' => $this->boolean(),
            'schoolbasedhealthcenter' => $this->string(),
            'sex' => $this->string(),
            'sexualorientation' => $this->string(),
            'sexualorientationother' => $this->string(),
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
        $this->dropTable('{{%put_patients}}');
    }
}
