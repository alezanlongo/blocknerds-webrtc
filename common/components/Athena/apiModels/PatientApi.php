<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class PatientApi extends BaseApiModel
{

    public $address1;
    public $address2;
    public $agriculturalworker;
    public $agriculturalworkertype;
    public $balances;
 
    protected $_balancesAr;
    public $caresummarydeliverypreference;
    public $city;
    public $claimbalancedetails;
    public $confidentialitycode;
    public $consenttocall;
    public $consenttotext;
    public $contacthomephone;
    public $contactmobilephone;
    public $contactname;
    public $contactpreference;
    public $contactpreference_announcement_email;
    public $contactpreference_announcement_phone;
    public $contactpreference_announcement_sms;
    public $contactpreference_appointment_email;
    public $contactpreference_appointment_phone;
    public $contactpreference_appointment_sms;
    public $contactpreference_billing_email;
    public $contactpreference_billing_phone;
    public $contactpreference_billing_sms;
    public $contactpreference_lab_email;
    public $contactpreference_lab_phone;
    public $contactpreference_lab_sms;
    public $contactrelationship;
    public $countrycode;
    public $countrycode3166;
    public $customfields;
 
    protected $_customfieldsAr;
    public $deceaseddate;
    public $defaultpharmacyncpdpid;
    public $departmentid;
    public $dob;
    public $donotcallyn;
    public $driverslicenseexpirationdate;
    public $driverslicensenumber;
    public $driverslicensestateid;
    public $driverslicenseurl;
    public $driverslicenseyn;
    public $email;
    public $emailexistsyn;
    public $employeraddress;
    public $employercity;
    public $employerfax;
    public $employerid;
    public $employername;
    public $employerphone;
    public $employerstate;
    public $employerzip;
    public $ethnicitycode;
    public $firstappointment;
    public $firstname;
    public $guarantoraddress1;
    public $guarantoraddress2;
    public $guarantoraddresssameaspatient;
    public $guarantorcity;
    public $guarantorcountrycode;
    public $guarantorcountrycode3166;
    public $guarantordob;
    public $guarantoremail;
    public $guarantoremployerid;
    public $guarantorfirstname;
    public $guarantorlastname;
    public $guarantormiddlename;
    public $guarantorphone;
    public $guarantorrelationshiptopatient;
    public $guarantorssn;
    public $guarantorstate;
    public $guarantorsuffix;
    public $guarantorzip;
    public $guardianfirstname;
    public $guardianlastname;
    public $guardianmiddlename;
    public $guardiansuffix;
    public $hasmobileyn;
    public $hierarchicalcode;
    public $homeboundyn;
    public $homeless;
    public $homelesstype;
    public $homephone;
    public $industrycode;
    public $insurances;
 
    protected $_insurancesAr;
    public $language6392code;
    public $lastappointment;
    public $lastemail;
    public $lastname;
    public $maritalstatus;
    public $maritalstatusname;
    public $medicationhistoryconsentverified;
    public $middlename;
    public $mobilecarrierid;
    public $mobilephone;
    public $nextkinname;
    public $nextkinphone;
    public $nextkinrelationship;
    public $notes;
    public $occupationcode;
    public $onlinestatementonlyyn;
    public $patientid;
    public $patientphotourl;
    public $patientphotoyn;
    public $portalaccessgiven;
    public $portalsignatureonfile;
    public $portalstatus;
    public $portaltermsonfile;
    public $povertylevelcalculated;
    public $povertylevelfamilysize;
    public $povertylevelfamilysizedeclined;
    public $povertylevelincomedeclined;
    public $povertylevelincomepayperiod;
    public $povertylevelincomeperpayperiod;
    public $povertylevelincomerangedeclined;
    public $preferredname;
    public $primarydepartmentid;
    public $primaryproviderid;
    public $privacyinformationverified;
    public $publichousing;
    public $race;
    public $racename;
    public $referralsourceid;
    public $registrationdate;
    public $schoolbasedhealthcenter;
    public $sex;
    public $ssn;
    public $state;
    public $status;
    public $suffix;
    public $veteran;
    public $workphone;
    public $zip;

    public function rules()
    {
        return [
            [['address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'caresummarydeliverypreference', 'city', 'claimbalancedetails', 'confidentialitycode', 'consenttocall', 'consenttotext', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactpreference_announcement_email', 'contactpreference_announcement_phone', 'contactpreference_announcement_sms', 'contactpreference_appointment_email', 'contactpreference_appointment_phone', 'contactpreference_appointment_sms', 'contactpreference_billing_email', 'contactpreference_billing_phone', 'contactpreference_billing_sms', 'contactpreference_lab_email', 'contactpreference_lab_phone', 'contactpreference_lab_sms', 'contactrelationship', 'countrycode', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'departmentid', 'dob', 'donotcallyn', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'driverslicenseurl', 'driverslicenseyn', 'email', 'emailexistsyn', 'employeraddress', 'employercity', 'employerfax', 'employerid', 'employername', 'employerphone', 'employerstate', 'employerzip', 'ethnicitycode', 'firstappointment', 'firstname', 'guarantoraddress1', 'guarantoraddress2', 'guarantoraddresssameaspatient', 'guarantorcity', 'guarantorcountrycode', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantoremployerid', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'hasmobileyn', 'hierarchicalcode', 'homeboundyn', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastappointment', 'lastemail', 'lastname', 'maritalstatus', 'maritalstatusname', 'medicationhistoryconsentverified', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'onlinestatementonlyyn', 'patientid', 'patientphotourl', 'patientphotoyn', 'portalaccessgiven', 'portalsignatureonfile', 'portalstatus', 'portaltermsonfile', 'povertylevelcalculated', 'povertylevelfamilysize', 'povertylevelfamilysizedeclined', 'povertylevelincomedeclined', 'povertylevelincomepayperiod', 'povertylevelincomeperpayperiod', 'povertylevelincomerangedeclined', 'preferredname', 'primarydepartmentid', 'primaryproviderid', 'privacyinformationverified', 'publichousing', 'race', 'racename', 'referralsourceid', 'registrationdate', 'schoolbasedhealthcenter', 'sex', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'trim'],
            [['departmentid', 'dob', 'email', 'firstname', 'lastname'], 'required'],
            [['address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'caresummarydeliverypreference', 'city', 'claimbalancedetails', 'confidentialitycode', 'consenttocall', 'consenttotext', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactpreference_announcement_email', 'contactpreference_announcement_phone', 'contactpreference_announcement_sms', 'contactpreference_appointment_email', 'contactpreference_appointment_phone', 'contactpreference_appointment_sms', 'contactpreference_billing_email', 'contactpreference_billing_phone', 'contactpreference_billing_sms', 'contactpreference_lab_email', 'contactpreference_lab_phone', 'contactpreference_lab_sms', 'contactrelationship', 'countrycode', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'departmentid', 'dob', 'donotcallyn', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'driverslicenseurl', 'driverslicenseyn', 'email', 'emailexistsyn', 'employeraddress', 'employercity', 'employerfax', 'employerid', 'employername', 'employerphone', 'employerstate', 'employerzip', 'ethnicitycode', 'firstappointment', 'firstname', 'guarantoraddress1', 'guarantoraddress2', 'guarantoraddresssameaspatient', 'guarantorcity', 'guarantorcountrycode', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantoremployerid', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'hasmobileyn', 'hierarchicalcode', 'homeboundyn', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastappointment', 'lastemail', 'lastname', 'maritalstatus', 'maritalstatusname', 'medicationhistoryconsentverified', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'onlinestatementonlyyn', 'patientid', 'patientphotourl', 'patientphotoyn', 'portalaccessgiven', 'portalsignatureonfile', 'portalstatus', 'portaltermsonfile', 'povertylevelcalculated', 'povertylevelfamilysize', 'povertylevelfamilysizedeclined', 'povertylevelincomedeclined', 'povertylevelincomepayperiod', 'povertylevelincomeperpayperiod', 'povertylevelincomerangedeclined', 'preferredname', 'primarydepartmentid', 'primaryproviderid', 'privacyinformationverified', 'publichousing', 'race', 'racename', 'referralsourceid', 'registrationdate', 'schoolbasedhealthcenter', 'sex', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->balances) && is_array($this->balances)) {
            foreach($this->balances as $balances) {
                $this->_balancesAr[] = new BalanceItemApi($balances);
            }
            $this->balances = $this->_balancesAr;
            $this->_balancesAr = [];//CHECKME
        }
        if (!empty($this->customfields) && is_array($this->customfields)) {
            foreach($this->customfields as $customfields) {
                $this->_customfieldsAr[] = new customfieldApi($customfields);
            }
            $this->customfields = $this->_customfieldsAr;
            $this->_customfieldsAr = [];//CHECKME
        }
        if (!empty($this->insurances) && is_array($this->insurances)) {
            foreach($this->insurances as $insurances) {
                $this->_insurancesAr[] = new InsurancePatientApi($insurances);
            }
            $this->insurances = $this->_insurancesAr;
            $this->_insurancesAr = [];//CHECKME
        }
    }

}
