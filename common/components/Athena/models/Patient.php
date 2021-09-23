<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $address1 Patient's address - 1st line
 * @property string $address2 Patient's address - 2nd line
 * @property string $agriculturalworker Used to identify this patient as an agricultural worker. Only settable if client has Social Determinant fields turned on.
 * @property string $agriculturalworkertype For patients that are agricultural workers, identifies the type of worker. Only settable if client has Social Determinant fields turned on.
 * @property BalanceItem[] $balances List of balances owed by the patient, broken down by provider (financial) group.
 * @property string $caresummarydeliverypreference The patient's preference for care summary delivery.
 * @property string $city Patient's city
 * @property string $claimbalancedetails Claim level details on patient balances.  (This is only included when SHOWBALANCEDETAILS is set.)
 * @property string $confidentialitycode Gives the confidentiality code for the patient. Only returned when IGNORERESTRICTIONS is set to true and COLCR_RETURN_CONFIDENTIALITY_CODE is ON
 * @property string $consenttocall The flag is used to record the consent of a patient to receive automated calls per FCC requirements. The requested legal language is 'Entry of any telephone contact number constitutes written consent to receive any automated, prerecorded, and artificial voice telephone calls initiated by the Practice. To alter or revoke this consent, visit the Patient Portal "Contact Preferences" page.'
 * @property string $consenttotext The flag is used to record the consent of a patient to receive text messages per FCC requirements. In order for this to be true, a valid mobile phone number must be set and the practice setting "Hide SMS Opt-in option" must be set to Off.
 * @property string $contacthomephone Emergency contact home phone.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $contactmobilephone Emergency contact mobile phone.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $contactname The name of the (emergency) person to contact about the patient. The contactname, contactrelationship, contacthomephone, and contactmobilephone fields are all related to the emergency contact for the patient. They are NOT related to the contractpreference_* fields.
 * @property string $contactpreference The MU-required field for "preferred contact method". This is not used by any automated systems.
 * @property string $contactpreference_announcement_email If set, the patient has indicated a preference to get or not get "announcement" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property string $contactpreference_announcement_phone If set, the patient has indicated a preference to get or not get "announcement" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property string $contactpreference_announcement_sms If set, the patient has indicated a preference to get or not get "announcement" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property string $contactpreference_appointment_email If set, the patient has indicated a preference to get or not get "appointment" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property string $contactpreference_appointment_phone If set, the patient has indicated a preference to get or not get "appointment" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property string $contactpreference_appointment_sms If set, the patient has indicated a preference to get or not get "appointment" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property string $contactpreference_billing_email If set, the patient has indicated a preference to get or not get "billing" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property string $contactpreference_billing_phone If set, the patient has indicated a preference to get or not get "billing" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property string $contactpreference_billing_sms If set, the patient has indicated a preference to get or not get "billing" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property string $contactpreference_lab_email If set, the patient has indicated a preference to get or not get "lab" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property string $contactpreference_lab_phone If set, the patient has indicated a preference to get or not get "lab" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property string $contactpreference_lab_sms If set, the patient has indicated a preference to get or not get "lab" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property string $contactrelationship Emergency contact relationship (one of SPOUSE, PARENT, CHILD, SIBLING, FRIEND, COUSIN, GUARDIAN, OTHER)
 * @property string $countrycode Patient's country code
 * @property string $countrycode3166 Patient's country code (ISO 3166-1)
 * @property customfield[] $customfields Same as /patients/{patientid}/customfields call, but without the department ID. Depending on setup, and only in large practices, the custom field values may or may not be the same between departments. If this is a concern, using the /patients/{patientid}/customfields call is preferred. Only for a single patient when showcustomfields is set to true.
 * @property string $deceaseddate If present, the date on which a patient died.
 * @property string $defaultpharmacyncpdpid The NCPDP ID of the patient's preferred pharmacy.  See http://www.ncpdp.org/ for details. Note: if updating this field, please make sure to have a CLINICALORDERTYPEGROUPID field as well.
 * @property string $departmentid Primary (registration) department ID.
 * @property string $dob Patient's DOB (mm/dd/yyyy)
 * @property string $donotcallyn Warning! This patient will not receive any communication from the practice if this field is set to true.
 * @property string $driverslicenseexpirationdate
 * @property string $driverslicensenumber
 * @property string $driverslicensestateid
 * @property string $driverslicenseurl The URL to the patient's driver's license
 * @property string $driverslicenseyn True if the patient has a driver's license uploaded
 * @property string $email Patient's email address.  'declined' can be used to indicate just that.
 * @property string $emailexistsyn True if email exists. False if patient declined. Null if status is unknown.
 * @property string $employeraddress The patient's employer's address.
 * @property string $employercity The patient's employer's city.
 * @property string $employerfax The patient's employer's fax.
 * @property string $employerid The patient's employer's ID (from /employers call)
 * @property string $employername The patient's employer's name.
 * @property string $employerphone The patient's employer's phone number. Normally, this is set by setting employerid. However, setting this value can be used to override this on an individual patient.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $employerstate The patient's employer's state.
 * @property string $employerzip The patient's employer's zip.
 * @property string $ethnicitycode Ethnicity of the patient, using the 2.16.840.1.113883.5.50 codeset. See http://www.hl7.org/implement/standards/fhir/terminologies-v3.html Special case: use "declined" to indicate that the patient declined to answer.
 * @property string $firstappointment The first appointment for this patient, excluding cancelled or no-show appointments. (mm/dd/yyyy h24:mi)
 * @property string $firstname Patient's first name
 * @property string $guarantoraddress1 Guarantor's address
 * @property string $guarantoraddress2 Guarantor's address - line 2
 * @property string $guarantoraddresssameaspatient The address of the guarantor is the same as the patient.
 * @property string $guarantorcity Guarantor's city
 * @property string $guarantorcountrycode Guarantor's country code
 * @property string $guarantorcountrycode3166 Guarantor's country code (ISO 3166-1)
 * @property string $guarantordob Guarantor's DOB (mm/dd/yyyy)
 * @property string $guarantoremail Guarantor's email address
 * @property string $guarantoremployerid The guaranror's employer's ID (from /employers call)
 * @property string $guarantorfirstname Guarantor's first name
 * @property string $guarantorlastname Guarantor's last name
 * @property string $guarantormiddlename Guarantor's middle name
 * @property string $guarantorphone Guarantor's phone number.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $guarantorrelationshiptopatient The guarantor's relationship to the patient
 * @property string $guarantorssn Guarantor's SSN
 * @property string $guarantorstate Guarantor's state (2 letter abbreviation)
 * @property string $guarantorsuffix Guarantor's name suffix
 * @property string $guarantorzip Guarantor's zip
 * @property string $guardianfirstname The first name of the patient's guardian.
 * @property string $guardianlastname The last name of the patient's guardian.
 * @property string $guardianmiddlename The middle name of the patient's guardian.
 * @property string $guardiansuffix The suffix of the patient's guardian.
 * @property string $hasmobileyn Set to false if a client has declined a phone number.
 * @property string $hierarchicalcode The patient race hierarchical code
 * @property string $homeboundyn If the patient is homebound, this is true.
 * @property string $homeless Used to identify this patient as homeless. Only settable if client has Social Determinant fields turned on.
 * @property string $homelesstype For patients that are homeless, provides more detail regarding the patient's homeless situation. Only settable if client has Social Determinant fields turned on.
 * @property string $homephone The patient's home phone number.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $industrycode Industry of the patient, using the US Census industry code (code system 2.16.840.1.113883.6.310).  "other" can be used as well.
 * @property InsurancePatient[] $insurances List of active patient insurance packages. Only shown for a single patient and if SHOWINSURANCE is set.
 * @property string $language6392code Language of the patient, using the ISO 639.2 code. (http://www.loc.gov/standards/iso639-2/php/code_list.php; "T" or terminology code) Special case: use "declined" to indicate that the patient declined to answer.
 * @property string $lastappointment The last appointment for this patient (before today), excluding cancelled or no-show appointments. (mm/dd/yyyy h24:mi)
 * @property string $lastemail Tthe last email for this patient on file.
 * @property string $lastname Patient's last name
 * @property string $maritalstatus Marital Status (D=Divorced, M=Married, S=Single, U=Unknown, W=Widowed, X=Separated, P=Partner)
 * @property string $maritalstatusname The long version of the marital status.
 * @property string $medicationhistoryconsentverified Medication history consent status.  If a practice doesn't have RXHub or Surescripts enabled, this will be null
 * @property string $middlename Patient's middle name
 * @property string $mobilecarrierid The ID of the mobile carrier, from /mobilecarriers or the list below.
 * @property string $mobilephone The patient's mobile phone number. On input, 'declined' can be used to indicate no number. (Alternatively, hasmobile can also be set to false. "declined" simply does this for you.)  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $nextkinname The full name of the next of kin.
 * @property string $nextkinphone The next of kin phone number.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $nextkinrelationship The next of kin relationship (one of SPOUSE, PARENT, CHILD, SIBLING, FRIEND, COUSIN, GUARDIAN, OTHER)
 * @property string $notes Notes associated with this patient.
 * @property string $occupationcode Occupation of the patient, using the US Census occupation code (code system 2.16.840.1.113883.6.240).  "other" can be used as well.
 * @property string $onlinestatementonlyyn Set to true if a patient wishes to get e-statements instead of paper statements. Should only be set for patients with an email address and clients with athenaCommunicator. The language we use in the portal is, "Future billing statements will be sent to you securely via your Patient Portal account. You will receive an email notice when new statements are available." This language is not required, but it is given as a suggestion.
 * @property string $patientid Please remember to never disclose this ID to patients since it may result in inadvertant disclosure that a patient exists in a practice already.
 * @property string $patientphotourl The URL to the patient photo
 * @property string $patientphotoyn True if the patient has a photo uploaded
 * @property string $portalaccessgiven This flag is set if the patient has been given access to the portal. This may be set by the API user if a patient has been given access to the portal "by providing a preprinted brochure or flyer showing the URL where patients can access their Patient Care Summaries." The practiceinfo endpoint can provide the portal URL. While technically allowed, it would be very unusual to set this to false via the API.
 * @property string $portalsignatureonfile
 * @property string $portalstatus Portal status details.  See /patients/{patientid}/portalstatus for details.
 * @property string $portaltermsonfile
 * @property string $povertylevelcalculated Patient's poverty level (% of the Federal Poverty Level), as calculated from family size, income per pay period, pay period, and state. Typically only valued if client has Federal Poverty Level fields turned on.
 * @property string $povertylevelfamilysize Patient's family size (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property string $povertylevelfamilysizedeclined Indicates if the patient delcines to provide "povertylevelfamilysize". Should be set to Yes if the patient declines.
 * @property string $povertylevelincomedeclined Indicates if the patient delcines to provide "povertylevelincomeperpayperiod". Should be set to Yes if the patient declines.
 * @property string $povertylevelincomepayperiod Patient's pay period (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property string $povertylevelincomeperpayperiod Patient's income per specified pay period (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property string $povertylevelincomerangedeclined Indicates whether or not the patient declines to provide an income level.
 * @property string $preferredname The patient's preferred name (i.e. nickname).
 * @property string $primarydepartmentid The patient's "current" department. This field is not always set by the practice.
 * @property string $primaryproviderid The "primary" provider for this patient, if set.
 * @property string $privacyinformationverified This flag is set if the patient's privacy information has been verified. Privacy information returns True if all of the items referenced in GET /patients/{patientid}/privacyinformationverified are true. Privacy information returns false if any of the items referenced in the GET /patients/{patientid}/privacyinformationverified API are false or expired.
 * @property string $publichousing Used to identify this patient as living in public housing. Only settable if client has Social Determinant fields turned on.
 * @property string $race The patient race, using the 2.16.840.1.113883.5.104 codeset.  See http://www.hl7.org/implement/standards/fhir/terminologies-v3.html Special case: use "declined" to indicate that the patient declined to answer. Multiple values or a tab-seperated list of codes is acceptable for multiple races for input.  The first race will be considered "primary".  Note: you must update all values at once if you update any.
 * @property string $racename The patient's primary race name.  See race for more complete details.
 * @property string $referralsourceid The referral / "how did you hear about us" ID.
 * @property string $registrationdate Date the patient was registered.
 * @property string $schoolbasedhealthcenter Used to identify this patient as school-based health center patient. Only settable if client has Social Determinant fields turned on.
 * @property string $sex Patient's sex (M/F)
 * @property string $ssn
 * @property string $state Patient's state (2 letter abbreviation)
 * @property string $status The "status" of the patient, one of active, inactive, prospective, or deleted.
 * @property string $suffix Patient's name suffix
 * @property string $veteran Used to identify this patient as a veteran. Only settable if client has Social Determinant fields turned on.
 * @property string $workphone The patient's work phone number.  Generally not used to contact a patient.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $zip Patient's zip.  Matching occurs on first 5 characters.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Patient extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%patients}}';
    }

    public function rules()
    {
        return [
            [['address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'caresummarydeliverypreference', 'city', 'claimbalancedetails', 'confidentialitycode', 'consenttocall', 'consenttotext', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactpreference_announcement_email', 'contactpreference_announcement_phone', 'contactpreference_announcement_sms', 'contactpreference_appointment_email', 'contactpreference_appointment_phone', 'contactpreference_appointment_sms', 'contactpreference_billing_email', 'contactpreference_billing_phone', 'contactpreference_billing_sms', 'contactpreference_lab_email', 'contactpreference_lab_phone', 'contactpreference_lab_sms', 'contactrelationship', 'countrycode', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'departmentid', 'dob', 'donotcallyn', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'driverslicenseurl', 'driverslicenseyn', 'email', 'emailexistsyn', 'employeraddress', 'employercity', 'employerfax', 'employerid', 'employername', 'employerphone', 'employerstate', 'employerzip', 'ethnicitycode', 'firstappointment', 'firstname', 'guarantoraddress1', 'guarantoraddress2', 'guarantoraddresssameaspatient', 'guarantorcity', 'guarantorcountrycode', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantoremployerid', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'hasmobileyn', 'hierarchicalcode', 'homeboundyn', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastappointment', 'lastemail', 'lastname', 'maritalstatus', 'maritalstatusname', 'medicationhistoryconsentverified', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'onlinestatementonlyyn', 'patientid', 'patientphotourl', 'patientphotoyn', 'portalaccessgiven', 'portalsignatureonfile', 'portalstatus', 'portaltermsonfile', 'povertylevelcalculated', 'povertylevelfamilysize', 'povertylevelfamilysizedeclined', 'povertylevelincomedeclined', 'povertylevelincomepayperiod', 'povertylevelincomeperpayperiod', 'povertylevelincomerangedeclined', 'preferredname', 'primarydepartmentid', 'primaryproviderid', 'privacyinformationverified', 'publichousing', 'race', 'racename', 'referralsourceid', 'registrationdate', 'schoolbasedhealthcenter', 'sex', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'trim'],
            [['departmentid', 'dob', 'email', 'firstname', 'lastname'], 'required'],
            [['address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'caresummarydeliverypreference', 'city', 'claimbalancedetails', 'confidentialitycode', 'consenttocall', 'consenttotext', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactpreference_announcement_email', 'contactpreference_announcement_phone', 'contactpreference_announcement_sms', 'contactpreference_appointment_email', 'contactpreference_appointment_phone', 'contactpreference_appointment_sms', 'contactpreference_billing_email', 'contactpreference_billing_phone', 'contactpreference_billing_sms', 'contactpreference_lab_email', 'contactpreference_lab_phone', 'contactpreference_lab_sms', 'contactrelationship', 'countrycode', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'departmentid', 'dob', 'donotcallyn', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'driverslicenseurl', 'driverslicenseyn', 'email', 'emailexistsyn', 'employeraddress', 'employercity', 'employerfax', 'employerid', 'employername', 'employerphone', 'employerstate', 'employerzip', 'ethnicitycode', 'firstappointment', 'firstname', 'guarantoraddress1', 'guarantoraddress2', 'guarantoraddresssameaspatient', 'guarantorcity', 'guarantorcountrycode', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantoremployerid', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'hasmobileyn', 'hierarchicalcode', 'homeboundyn', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastappointment', 'lastemail', 'lastname', 'maritalstatus', 'maritalstatusname', 'medicationhistoryconsentverified', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'onlinestatementonlyyn', 'patientid', 'patientphotourl', 'patientphotoyn', 'portalaccessgiven', 'portalsignatureonfile', 'portalstatus', 'portaltermsonfile', 'povertylevelcalculated', 'povertylevelfamilysize', 'povertylevelfamilysizedeclined', 'povertylevelincomedeclined', 'povertylevelincomepayperiod', 'povertylevelincomeperpayperiod', 'povertylevelincomerangedeclined', 'preferredname', 'primarydepartmentid', 'primaryproviderid', 'privacyinformationverified', 'publichousing', 'race', 'racename', 'referralsourceid', 'registrationdate', 'schoolbasedhealthcenter', 'sex', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getBalances()
    {
        return $this->hasMany(BalanceItem::class, ['patient_id' => 'id']);
    }

    public function getCustomfields()
    {
        return $this->hasMany(customfield::class, ['patient_id' => 'id']);
    }

    public function getInsurances()
    {
        return $this->hasMany(InsurancePatient::class, ['patient_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->address1 = ArrayHelper::getValue($apiObject, 'address1');
        $this->address2 = ArrayHelper::getValue($apiObject, 'address2');
        $this->agriculturalworker = ArrayHelper::getValue($apiObject, 'agriculturalworker');
        $this->agriculturalworkertype = ArrayHelper::getValue($apiObject, 'agriculturalworkertype');
        $this->balances = ArrayHelper::getValue($apiObject, 'balances');
        $this->caresummarydeliverypreference = ArrayHelper::getValue($apiObject, 'caresummarydeliverypreference');
        $this->city = ArrayHelper::getValue($apiObject, 'city');
        $this->claimbalancedetails = ArrayHelper::getValue($apiObject, 'claimbalancedetails');
        $this->confidentialitycode = ArrayHelper::getValue($apiObject, 'confidentialitycode');
        $this->consenttocall = ArrayHelper::getValue($apiObject, 'consenttocall');
        $this->consenttotext = ArrayHelper::getValue($apiObject, 'consenttotext');
        $this->contacthomephone = ArrayHelper::getValue($apiObject, 'contacthomephone');
        $this->contactmobilephone = ArrayHelper::getValue($apiObject, 'contactmobilephone');
        $this->contactname = ArrayHelper::getValue($apiObject, 'contactname');
        $this->contactpreference = ArrayHelper::getValue($apiObject, 'contactpreference');
        $this->contactpreference_announcement_email = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_email');
        $this->contactpreference_announcement_phone = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_phone');
        $this->contactpreference_announcement_sms = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_sms');
        $this->contactpreference_appointment_email = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_email');
        $this->contactpreference_appointment_phone = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_phone');
        $this->contactpreference_appointment_sms = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_sms');
        $this->contactpreference_billing_email = ArrayHelper::getValue($apiObject, 'contactpreference_billing_email');
        $this->contactpreference_billing_phone = ArrayHelper::getValue($apiObject, 'contactpreference_billing_phone');
        $this->contactpreference_billing_sms = ArrayHelper::getValue($apiObject, 'contactpreference_billing_sms');
        $this->contactpreference_lab_email = ArrayHelper::getValue($apiObject, 'contactpreference_lab_email');
        $this->contactpreference_lab_phone = ArrayHelper::getValue($apiObject, 'contactpreference_lab_phone');
        $this->contactpreference_lab_sms = ArrayHelper::getValue($apiObject, 'contactpreference_lab_sms');
        $this->contactrelationship = ArrayHelper::getValue($apiObject, 'contactrelationship');
        $this->countrycode = ArrayHelper::getValue($apiObject, 'countrycode');
        $this->countrycode3166 = ArrayHelper::getValue($apiObject, 'countrycode3166');
        $this->customfields = ArrayHelper::getValue($apiObject, 'customfields');
        $this->deceaseddate = ArrayHelper::getValue($apiObject, 'deceaseddate');
        $this->defaultpharmacyncpdpid = ArrayHelper::getValue($apiObject, 'defaultpharmacyncpdpid');
        $this->departmentid = ArrayHelper::getValue($apiObject, 'departmentid');
        $this->dob = ArrayHelper::getValue($apiObject, 'dob');
        $this->donotcallyn = ArrayHelper::getValue($apiObject, 'donotcallyn');
        $this->driverslicenseexpirationdate = ArrayHelper::getValue($apiObject, 'driverslicenseexpirationdate');
        $this->driverslicensenumber = ArrayHelper::getValue($apiObject, 'driverslicensenumber');
        $this->driverslicensestateid = ArrayHelper::getValue($apiObject, 'driverslicensestateid');
        $this->driverslicenseurl = ArrayHelper::getValue($apiObject, 'driverslicenseurl');
        $this->driverslicenseyn = ArrayHelper::getValue($apiObject, 'driverslicenseyn');
        $this->email = ArrayHelper::getValue($apiObject, 'email');
        $this->emailexistsyn = ArrayHelper::getValue($apiObject, 'emailexistsyn');
        $this->employeraddress = ArrayHelper::getValue($apiObject, 'employeraddress');
        $this->employercity = ArrayHelper::getValue($apiObject, 'employercity');
        $this->employerfax = ArrayHelper::getValue($apiObject, 'employerfax');
        $this->employerid = ArrayHelper::getValue($apiObject, 'employerid');
        $this->employername = ArrayHelper::getValue($apiObject, 'employername');
        $this->employerphone = ArrayHelper::getValue($apiObject, 'employerphone');
        $this->employerstate = ArrayHelper::getValue($apiObject, 'employerstate');
        $this->employerzip = ArrayHelper::getValue($apiObject, 'employerzip');
        $this->ethnicitycode = ArrayHelper::getValue($apiObject, 'ethnicitycode');
        $this->firstappointment = ArrayHelper::getValue($apiObject, 'firstappointment');
        $this->firstname = ArrayHelper::getValue($apiObject, 'firstname');
        $this->guarantoraddress1 = ArrayHelper::getValue($apiObject, 'guarantoraddress1');
        $this->guarantoraddress2 = ArrayHelper::getValue($apiObject, 'guarantoraddress2');
        $this->guarantoraddresssameaspatient = ArrayHelper::getValue($apiObject, 'guarantoraddresssameaspatient');
        $this->guarantorcity = ArrayHelper::getValue($apiObject, 'guarantorcity');
        $this->guarantorcountrycode = ArrayHelper::getValue($apiObject, 'guarantorcountrycode');
        $this->guarantorcountrycode3166 = ArrayHelper::getValue($apiObject, 'guarantorcountrycode3166');
        $this->guarantordob = ArrayHelper::getValue($apiObject, 'guarantordob');
        $this->guarantoremail = ArrayHelper::getValue($apiObject, 'guarantoremail');
        $this->guarantoremployerid = ArrayHelper::getValue($apiObject, 'guarantoremployerid');
        $this->guarantorfirstname = ArrayHelper::getValue($apiObject, 'guarantorfirstname');
        $this->guarantorlastname = ArrayHelper::getValue($apiObject, 'guarantorlastname');
        $this->guarantormiddlename = ArrayHelper::getValue($apiObject, 'guarantormiddlename');
        $this->guarantorphone = ArrayHelper::getValue($apiObject, 'guarantorphone');
        $this->guarantorrelationshiptopatient = ArrayHelper::getValue($apiObject, 'guarantorrelationshiptopatient');
        $this->guarantorssn = ArrayHelper::getValue($apiObject, 'guarantorssn');
        $this->guarantorstate = ArrayHelper::getValue($apiObject, 'guarantorstate');
        $this->guarantorsuffix = ArrayHelper::getValue($apiObject, 'guarantorsuffix');
        $this->guarantorzip = ArrayHelper::getValue($apiObject, 'guarantorzip');
        $this->guardianfirstname = ArrayHelper::getValue($apiObject, 'guardianfirstname');
        $this->guardianlastname = ArrayHelper::getValue($apiObject, 'guardianlastname');
        $this->guardianmiddlename = ArrayHelper::getValue($apiObject, 'guardianmiddlename');
        $this->guardiansuffix = ArrayHelper::getValue($apiObject, 'guardiansuffix');
        $this->hasmobileyn = ArrayHelper::getValue($apiObject, 'hasmobileyn');
        $this->hierarchicalcode = ArrayHelper::getValue($apiObject, 'hierarchicalcode');
        $this->homeboundyn = ArrayHelper::getValue($apiObject, 'homeboundyn');
        $this->homeless = ArrayHelper::getValue($apiObject, 'homeless');
        $this->homelesstype = ArrayHelper::getValue($apiObject, 'homelesstype');
        $this->homephone = ArrayHelper::getValue($apiObject, 'homephone');
        $this->industrycode = ArrayHelper::getValue($apiObject, 'industrycode');
        $this->insurances = ArrayHelper::getValue($apiObject, 'insurances');
        $this->language6392code = ArrayHelper::getValue($apiObject, 'language6392code');
        $this->lastappointment = ArrayHelper::getValue($apiObject, 'lastappointment');
        $this->lastemail = ArrayHelper::getValue($apiObject, 'lastemail');
        $this->lastname = ArrayHelper::getValue($apiObject, 'lastname');
        $this->maritalstatus = ArrayHelper::getValue($apiObject, 'maritalstatus');
        $this->maritalstatusname = ArrayHelper::getValue($apiObject, 'maritalstatusname');
        $this->medicationhistoryconsentverified = ArrayHelper::getValue($apiObject, 'medicationhistoryconsentverified');
        $this->middlename = ArrayHelper::getValue($apiObject, 'middlename');
        $this->mobilecarrierid = ArrayHelper::getValue($apiObject, 'mobilecarrierid');
        $this->mobilephone = ArrayHelper::getValue($apiObject, 'mobilephone');
        $this->nextkinname = ArrayHelper::getValue($apiObject, 'nextkinname');
        $this->nextkinphone = ArrayHelper::getValue($apiObject, 'nextkinphone');
        $this->nextkinrelationship = ArrayHelper::getValue($apiObject, 'nextkinrelationship');
        $this->notes = ArrayHelper::getValue($apiObject, 'notes');
        $this->occupationcode = ArrayHelper::getValue($apiObject, 'occupationcode');
        $this->onlinestatementonlyyn = ArrayHelper::getValue($apiObject, 'onlinestatementonlyyn');
        $this->externalId = ArrayHelper::getValue($apiObject, 'patientid');
        $this->patientphotourl = ArrayHelper::getValue($apiObject, 'patientphotourl');
        $this->patientphotoyn = ArrayHelper::getValue($apiObject, 'patientphotoyn');
        $this->portalaccessgiven = ArrayHelper::getValue($apiObject, 'portalaccessgiven');
        $this->portalsignatureonfile = ArrayHelper::getValue($apiObject, 'portalsignatureonfile');
        $this->portalstatus = ArrayHelper::getValue($apiObject, 'portalstatus');
        $this->portaltermsonfile = ArrayHelper::getValue($apiObject, 'portaltermsonfile');
        $this->povertylevelcalculated = ArrayHelper::getValue($apiObject, 'povertylevelcalculated');
        $this->povertylevelfamilysize = ArrayHelper::getValue($apiObject, 'povertylevelfamilysize');
        $this->povertylevelfamilysizedeclined = ArrayHelper::getValue($apiObject, 'povertylevelfamilysizedeclined');
        $this->povertylevelincomedeclined = ArrayHelper::getValue($apiObject, 'povertylevelincomedeclined');
        $this->povertylevelincomepayperiod = ArrayHelper::getValue($apiObject, 'povertylevelincomepayperiod');
        $this->povertylevelincomeperpayperiod = ArrayHelper::getValue($apiObject, 'povertylevelincomeperpayperiod');
        $this->povertylevelincomerangedeclined = ArrayHelper::getValue($apiObject, 'povertylevelincomerangedeclined');
        $this->preferredname = ArrayHelper::getValue($apiObject, 'preferredname');
        $this->primarydepartmentid = ArrayHelper::getValue($apiObject, 'primarydepartmentid');
        $this->primaryproviderid = ArrayHelper::getValue($apiObject, 'primaryproviderid');
        $this->privacyinformationverified = ArrayHelper::getValue($apiObject, 'privacyinformationverified');
        $this->publichousing = ArrayHelper::getValue($apiObject, 'publichousing');
        $this->race = ArrayHelper::getValue($apiObject, 'race');
        $this->racename = ArrayHelper::getValue($apiObject, 'racename');
        $this->referralsourceid = ArrayHelper::getValue($apiObject, 'referralsourceid');
        $this->registrationdate = ArrayHelper::getValue($apiObject, 'registrationdate');
        $this->schoolbasedhealthcenter = ArrayHelper::getValue($apiObject, 'schoolbasedhealthcenter');
        $this->sex = ArrayHelper::getValue($apiObject, 'sex');
        $this->ssn = ArrayHelper::getValue($apiObject, 'ssn');
        $this->state = ArrayHelper::getValue($apiObject, 'state');
        $this->status = ArrayHelper::getValue($apiObject, 'status');
        $this->suffix = ArrayHelper::getValue($apiObject, 'suffix');
        $this->veteran = ArrayHelper::getValue($apiObject, 'veteran');
        $this->workphone = ArrayHelper::getValue($apiObject, 'workphone');
        $this->zip = ArrayHelper::getValue($apiObject, 'zip');
        // $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }

    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
