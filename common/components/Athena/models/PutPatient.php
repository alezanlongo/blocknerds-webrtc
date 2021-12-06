<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property bool $PATIENTFACINGCALL When 'true' is passed we will collect relevant data and store in our database.
 * @property string $THIRDPARTYUSERNAME User name of the patient in the third party application.
 * @property string $address1 Patient's address - 1st line (Max length: 100)
 * @property string $address2 Patient's address - 2nd line (Max length: 100)
 * @property string $agriculturalworker Used to identify this patient as an agricultural worker. Only settable if client has Social Determinant fields turned on.
 * @property string $agriculturalworkertype For patients that are agricultural workers, identifies the type of worker. Only settable if client has Social Determinant fields turned on.
 * @property string $altfirstname Alternate first name that differs from legal name. This is only available in practices with the appropriate practice settings.
 * @property string $assignedsexatbirth Sex that this patient was assigned at birth. This is only available in practices with the appropriate practice settings.
 * @property string $caresummarydeliverypreference The patient's preference for care summary delivery.
 * @property string $city Patient's city (Max length: 30)
 * @property string $clinicalordertypegroupid The clinical order type group of the clinical provider (Prescription: 10, Lab: 11, Vaccinations: 16).
 * @property bool $consenttocall The flag is used to record the consent of a patient to receive automated calls per FCC requirements. The requested legal language is 'Entry of any telephone contact number constitutes written consent to receive any automated, prerecorded, and artificial voice telephone calls initiated by the Practice. To alter or revoke this consent, visit the Patient Portal "Contact Preferences" page.'
 * @property bool $consenttotext The flag is used to record the consent of a patient to receive text messages per FCC requirements. In order for this to be true, a valid mobile phone number must be set and the practice setting "Hide SMS Opt-in option" must be set to Off.
 * @property string $contacthomephone Emergency contact home phone.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $contactmobilephone Emergency contact mobile phone.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $contactname The name of the (emergency) person to contact about the patient. The contactname, contactrelationship, contacthomephone, and contactmobilephone fields are all related to the emergency contact for the patient. They are NOT related to the contractpreference_* fields.
 * @property string $contactpreference The MU-required field for "preferred contact method". This is not used by any automated systems.
 * @property bool $contactpreference_announcement_email If set, the patient has indicated a preference to get or not get "announcement" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property bool $contactpreference_announcement_phone If set, the patient has indicated a preference to get or not get "announcement" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property bool $contactpreference_announcement_sms If set, the patient has indicated a preference to get or not get "announcement" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property bool $contactpreference_appointment_email If set, the patient has indicated a preference to get or not get "appointment" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property bool $contactpreference_appointment_phone If set, the patient has indicated a preference to get or not get "appointment" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property bool $contactpreference_appointment_sms If set, the patient has indicated a preference to get or not get "appointment" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property bool $contactpreference_billing_email If set, the patient has indicated a preference to get or not get "billing" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property bool $contactpreference_billing_phone If set, the patient has indicated a preference to get or not get "billing" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property bool $contactpreference_billing_sms If set, the patient has indicated a preference to get or not get "billing" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property bool $contactpreference_lab_email If set, the patient has indicated a preference to get or not get "lab" communications delivered via email.  Note that this will not be present if the practice or patient has not set it.For completeness, turning email off is supported via the API, but it is discouraged. When email is off, patients may not not get messages from the patient portal.
 * @property bool $contactpreference_lab_phone If set, the patient has indicated a preference to get or not get "lab" communications delivered via phone.  Note that this will not be present if the practice or patient has not set it.
 * @property bool $contactpreference_lab_sms If set, the patient has indicated a preference to get or not get "lab" communications delivered via SMS.  Note that this will not be present if the practice or patient has not set it.For SMS, there is specific terms of service language that must be used when displaying this as an option to be turned on.  Turning on must be an action by the patient, not a practice user.
 * @property string $contactrelationship Emergency contact relationship (one of SPOUSE, PARENT, CHILD, SIBLING, FRIEND, COUSIN, GUARDIAN, OTHER)
 * @property string $countrycode3166 Patient's country code (ISO 3166-1)
 * @property string $deceaseddate If present, the date on which a patient died.
 * @property string $defaultpharmacyncpdpid The NCPDP ID of the patient's preferred pharmacy.  See http://www.ncpdp.org/ for details. Note: if updating this field, please make sure to have a CLINICALORDERTYPEGROUPID field as well.
 * @property int $departmentid Primary (registration) department ID.
 * @property string $dob Patient's DOB (mm/dd/yyyy)
 * @property bool $donotcallyn Warning! This patient will not receive any communication from the practice if this field is set to true. This field should only be used if you are absolutely certain that's what you want to do.
 * @property string $driverslicenseexpirationdate The expiration date of the patient's driver's license.
 * @property string $driverslicensenumber The number of the patient's driver's license
 * @property string $driverslicensestateid The state of the patient's driver's license. This is in the form of a 2 letter state code.
 * @property string $email Patient's email address.  'declined' can be used to indicate just that.
 * @property int $employerid The patient's employer's ID (from /employers call)
 * @property string $employerphone The patient's employer's phone number. Normally, this is set by setting employerid. However, setting this value can be used to override this on an individual patient.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $ethnicitycode Ethnicity of the patient, using the 2.16.840.1.113883.5.50 codeset. See http://www.hl7.org/implement/standards/fhir/terminologies-v3.html Special case: use "declined" to indicate that the patient declined to answer.
 * @property string $firstname Patient's first name
 * @property string $genderidentity Gender this patient identifies with. This is only available in practices with the appropriate practice settings. To see the available options for this input, please see GET /configuration/patients/genderidentity?show2015edcehrtvalues=true
 * @property string $genderidentityother Only valid when used in conjunction with a gender identity choice that allows the patient to describe their identity (if it doesn't conform to any other choice).
 * @property string $guarantoraddress1 Guarantor's address (Max length: 100)
 * @property string $guarantoraddress2 Guarantor's address - line 2 (Max length: 100)
 * @property bool $guarantoraddresssameaspatient If set, the address of the guarantor is the same as the patient.
 * @property string $guarantorcity Guarantor's city (Max length: 30)
 * @property string $guarantorcountrycode3166 Guarantor's country code (ISO 3166-1)
 * @property string $guarantordob Guarantor's DOB (mm/dd/yyyy)
 * @property string $guarantoremail Guarantor's email address
 * @property int $guarantoremployerid The guaranror's employer's ID (from /employers call)
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
 * @property bool $hasmobileyn Set to false if a client has declined a phone number.
 * @property bool $homeboundyn If the patient is homebound, this is true.
 * @property string $homeless Used to identify this patient as homeless. Only settable if client has Social Determinant fields turned on.
 * @property string $homelesstype For patients that are homeless, provides more detail regarding the patient's homeless situation. Only settable if client has Social Determinant fields turned on.
 * @property string $homephone The patient's home phone number.  Invalid numbers in a GET will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA. Only phone numbers that exist in the North American Naming Plan (NANP) are acceptable for input.
 * @property bool $ignorerestrictions Set to true to allow ability to find patients with record restrictions and blocked patients. This should only be used when there is no reflection to the patient at all that a match was found or not found.
 * @property string $industrycode Industry of the patient, using the US Census industry code (code system 2.16.840.1.113883.6.310).  "other" can be used as well.
 * @property string $language6392code Language of the patient, using the ISO 639.2 code. (http://www.loc.gov/standards/iso639-2/php/code_list.php; "T" or terminology code) Special case: use "declined" to indicate that the patient declined to answer.
 * @property string $lastname Patient's last name
 * @property int $lookupdepartmentid Use this in practices that register copies of patients in different departments in order to make sure you are updating the correct version of the patient.
 * @property string $maritalstatus Marital Status (D=Divorced, M=Married, S=Single, U=Unknown, W=Widowed, X=Separated, P=Partner)
 * @property string $middlename Patient's middle name
 * @property string $mobilecarrierid The ID of the mobile carrier, from /mobilecarriers or the list below.
 * @property string $mobilephone The patient's mobile phone number. On input, 'declined' can be used to indicate no number. (Alternatively, hasmobile can also be set to false. "declined" simply does this for you.) Invalid numbers in a GET will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA. Only phone numbers that exist in the North American Naming Plan (NANP) are acceptable for input.
 * @property string $nextkinname The full name of the next of kin.
 * @property string $nextkinphone The next of kin phone number.  Invalid numbers in a GET/PUT will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA.  Invalid numbers in a POST will be ignored, possibly resulting in an error.
 * @property string $nextkinrelationship The next of kin relationship (one of SPOUSE, PARENT, CHILD, SIBLING, FRIEND, COUSIN, GUARDIAN, OTHER)
 * @property string $notes Notes associated with this patient.
 * @property string $occupationcode Occupation of the patient, using the US Census occupation code (code system 2.16.840.1.113883.6.240).  "other" can be used as well.
 * @property bool $onlinestatementonlyyn Set to true if a patient wishes to get e-statements instead of paper statements. Should only be set for patients with an email address and clients with athenaCommunicator. The language we use in the portal is, "Future billing statements will be sent to you securely via your Patient Portal account. You will receive an email notice when new statements are available." This language is not required, but it is given as a suggestion.
 * @property bool $portalaccessgiven This flag is set if the patient has been given access to the portal. This may be set by the API user if a patient has been given access to the portal "by providing a preprinted brochure or flyer showing the URL where patients can access their Patient Care Summaries." The practiceinfo endpoint can provide the portal URL. While technically allowed, it would be very unusual to set this to false via the API.
 * @property float $povertylevelcalculated Patient's poverty level (% of the Federal Poverty Level), as calculated from family size, income per pay period, pay period, and state. Typically only valued if client has Federal Poverty Level fields turned on.
 * @property float $povertylevelfamilysize Patient's family size (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property bool $povertylevelfamilysizedeclined Indicates if the patient delcines to provide "povertylevelfamilysize". Should be set to Yes if the patient declines.
 * @property bool $povertylevelincomedeclined Indicates if the patient delcines to provide "povertylevelincomeperpayperiod". Should be set to Yes if the patient declines.
 * @property string $povertylevelincomepayperiod Patient's pay period (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property int $povertylevelincomeperpayperiod Patient's income per specified pay period (used for determining poverty level). Only settable if client has Federal Poverty Level fields turned on.
 * @property bool $povertylevelincomerangedeclined Indicates whether or not the patient declines to provide an income level (povertylevelcalculated).
 * @property string $preferredname The patient's preferred name (i.e. nickname).
 * @property string $preferredpronouns Pronoun this patient uses.  This is only available in practices with the appropriate practice settings.
 * @property string $primarydepartmentid The patient's "current" department. This field is not always set by the practice.
 * @property string $primaryproviderid The "primary" provider for this patient, if set.
 * @property string $publichousing Used to identify this patient as living in public housing. Only settable if client has Social Determinant fields turned on.
 * @property string $race The patient race, using the 2.16.840.1.113883.5.104 codeset. See http://www.hl7.org/implement/standards/fhir/terminologies-v3.html Special case: use "declined" to indicate that the patient declined to answer. Multiple values or a tab-seperated list of codes is acceptable for multiple races for input. The first race will be considered "primary".  Note: you must update all values at once if you update any.
 * @property string $referralsourceid The referral / "how did you hear about us" ID.
 * @property string $referralsourceother If selecting "other" for referral source, this is the text field that can be filled out.
 * @property bool $registerpatientindepartment If you use LOOKUPDEPARTMENTID to get the local copy of a patient to update, and if the patient is not currently registered in that department, setting this flag will register a new copy of this patient in that department.
 * @property bool $returnerroroninvalidemail Returns Error on invalid email if true, default false.
 * @property string $schoolbasedhealthcenter Used to identify this patient as school-based health center patient. Only settable if client has Social Determinant fields turned on.
 * @property string $sex Patient's sex (M/F)
 * @property string $sexualorientation Sexual orientation of this patient. This is only available in practices with the appropriate practice settings.
 * @property string $sexualorientationother Only valid when used in conjunction with a sexual orientation choice that allows the patient to describe their orientation (if it doesn't conform to any other choice).
 * @property string $ssn
 * @property string $state Patient's state (2 letter abbreviation)
 * @property string $status The "status" of the patient, either active, inactive or prospective
 * @property string $suffix Patient's name suffix
 * @property string $veteran Used to identify this patient as a veteran. Only settable if client has Social Determinant fields turned on.
 * @property string $workphone The patient's work phone number.  Generally not used to contact a patient.  Invalid numbers in a GET will be ignored.  Patient phone numbers and other data may change, and one phone number may be associated with multiple patients. You are responsible for taking additional steps to verify patient identity and for using this data in accordance with applicable law, including HIPAA. Only phone numbers that exist in the North American Naming Plan (NANP) are acceptable for input.
 * @property string $zip Patient's zip.  Matching occurs on first 5 characters.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutPatient extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_patients}}';
    }

    public function rules()
    {
        return [
            [['THIRDPARTYUSERNAME', 'address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'altfirstname', 'assignedsexatbirth', 'caresummarydeliverypreference', 'city', 'clinicalordertypegroupid', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactrelationship', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'dob', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'email', 'employerphone', 'ethnicitycode', 'firstname', 'genderidentity', 'genderidentityother', 'guarantoraddress1', 'guarantoraddress2', 'guarantorcity', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastname', 'maritalstatus', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'povertylevelincomepayperiod', 'preferredname', 'preferredpronouns', 'primarydepartmentid', 'primaryproviderid', 'publichousing', 'race', 'referralsourceid', 'referralsourceother', 'schoolbasedhealthcenter', 'sex', 'sexualorientation', 'sexualorientationother', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'trim'],
            [['THIRDPARTYUSERNAME', 'address1', 'address2', 'agriculturalworker', 'agriculturalworkertype', 'altfirstname', 'assignedsexatbirth', 'caresummarydeliverypreference', 'city', 'clinicalordertypegroupid', 'contacthomephone', 'contactmobilephone', 'contactname', 'contactpreference', 'contactrelationship', 'countrycode3166', 'deceaseddate', 'defaultpharmacyncpdpid', 'dob', 'driverslicenseexpirationdate', 'driverslicensenumber', 'driverslicensestateid', 'email', 'employerphone', 'ethnicitycode', 'firstname', 'genderidentity', 'genderidentityother', 'guarantoraddress1', 'guarantoraddress2', 'guarantorcity', 'guarantorcountrycode3166', 'guarantordob', 'guarantoremail', 'guarantorfirstname', 'guarantorlastname', 'guarantormiddlename', 'guarantorphone', 'guarantorrelationshiptopatient', 'guarantorssn', 'guarantorstate', 'guarantorsuffix', 'guarantorzip', 'guardianfirstname', 'guardianlastname', 'guardianmiddlename', 'guardiansuffix', 'homeless', 'homelesstype', 'homephone', 'industrycode', 'language6392code', 'lastname', 'maritalstatus', 'middlename', 'mobilecarrierid', 'mobilephone', 'nextkinname', 'nextkinphone', 'nextkinrelationship', 'notes', 'occupationcode', 'povertylevelincomepayperiod', 'preferredname', 'preferredpronouns', 'primarydepartmentid', 'primaryproviderid', 'publichousing', 'race', 'referralsourceid', 'referralsourceother', 'schoolbasedhealthcenter', 'sex', 'sexualorientation', 'sexualorientationother', 'ssn', 'state', 'status', 'suffix', 'veteran', 'workphone', 'zip'], 'string'],
            [['departmentid', 'employerid', 'guarantoremployerid', 'lookupdepartmentid', 'povertylevelincomeperpayperiod', 'externalId', 'id'], 'integer'],
            [['PATIENTFACINGCALL', 'consenttocall', 'consenttotext', 'contactpreference_announcement_email', 'contactpreference_announcement_phone', 'contactpreference_announcement_sms', 'contactpreference_appointment_email', 'contactpreference_appointment_phone', 'contactpreference_appointment_sms', 'contactpreference_billing_email', 'contactpreference_billing_phone', 'contactpreference_billing_sms', 'contactpreference_lab_email', 'contactpreference_lab_phone', 'contactpreference_lab_sms', 'donotcallyn', 'guarantoraddresssameaspatient', 'hasmobileyn', 'homeboundyn', 'ignorerestrictions', 'onlinestatementonlyyn', 'portalaccessgiven', 'povertylevelfamilysizedeclined', 'povertylevelincomedeclined', 'povertylevelincomerangedeclined', 'registerpatientindepartment', 'returnerroroninvalidemail'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($PATIENTFACINGCALL = ArrayHelper::getValue($apiObject, 'PATIENTFACINGCALL')) {
            $this->PATIENTFACINGCALL = $PATIENTFACINGCALL;
        }
        if($THIRDPARTYUSERNAME = ArrayHelper::getValue($apiObject, 'THIRDPARTYUSERNAME')) {
            $this->THIRDPARTYUSERNAME = $THIRDPARTYUSERNAME;
        }
        if($address1 = ArrayHelper::getValue($apiObject, 'address1')) {
            $this->address1 = $address1;
        }
        if($address2 = ArrayHelper::getValue($apiObject, 'address2')) {
            $this->address2 = $address2;
        }
        if($agriculturalworker = ArrayHelper::getValue($apiObject, 'agriculturalworker')) {
            $this->agriculturalworker = $agriculturalworker;
        }
        if($agriculturalworkertype = ArrayHelper::getValue($apiObject, 'agriculturalworkertype')) {
            $this->agriculturalworkertype = $agriculturalworkertype;
        }
        if($altfirstname = ArrayHelper::getValue($apiObject, 'altfirstname')) {
            $this->altfirstname = $altfirstname;
        }
        if($assignedsexatbirth = ArrayHelper::getValue($apiObject, 'assignedsexatbirth')) {
            $this->assignedsexatbirth = $assignedsexatbirth;
        }
        if($caresummarydeliverypreference = ArrayHelper::getValue($apiObject, 'caresummarydeliverypreference')) {
            $this->caresummarydeliverypreference = $caresummarydeliverypreference;
        }
        if($city = ArrayHelper::getValue($apiObject, 'city')) {
            $this->city = $city;
        }
        if($clinicalordertypegroupid = ArrayHelper::getValue($apiObject, 'clinicalordertypegroupid')) {
            $this->clinicalordertypegroupid = $clinicalordertypegroupid;
        }
        if($consenttocall = ArrayHelper::getValue($apiObject, 'consenttocall')) {
            $this->consenttocall = $consenttocall;
        }
        if($consenttotext = ArrayHelper::getValue($apiObject, 'consenttotext')) {
            $this->consenttotext = $consenttotext;
        }
        if($contacthomephone = ArrayHelper::getValue($apiObject, 'contacthomephone')) {
            $this->contacthomephone = $contacthomephone;
        }
        if($contactmobilephone = ArrayHelper::getValue($apiObject, 'contactmobilephone')) {
            $this->contactmobilephone = $contactmobilephone;
        }
        if($contactname = ArrayHelper::getValue($apiObject, 'contactname')) {
            $this->contactname = $contactname;
        }
        if($contactpreference = ArrayHelper::getValue($apiObject, 'contactpreference')) {
            $this->contactpreference = $contactpreference;
        }
        if($contactpreference_announcement_email = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_email')) {
            $this->contactpreference_announcement_email = $contactpreference_announcement_email;
        }
        if($contactpreference_announcement_phone = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_phone')) {
            $this->contactpreference_announcement_phone = $contactpreference_announcement_phone;
        }
        if($contactpreference_announcement_sms = ArrayHelper::getValue($apiObject, 'contactpreference_announcement_sms')) {
            $this->contactpreference_announcement_sms = $contactpreference_announcement_sms;
        }
        if($contactpreference_appointment_email = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_email')) {
            $this->contactpreference_appointment_email = $contactpreference_appointment_email;
        }
        if($contactpreference_appointment_phone = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_phone')) {
            $this->contactpreference_appointment_phone = $contactpreference_appointment_phone;
        }
        if($contactpreference_appointment_sms = ArrayHelper::getValue($apiObject, 'contactpreference_appointment_sms')) {
            $this->contactpreference_appointment_sms = $contactpreference_appointment_sms;
        }
        if($contactpreference_billing_email = ArrayHelper::getValue($apiObject, 'contactpreference_billing_email')) {
            $this->contactpreference_billing_email = $contactpreference_billing_email;
        }
        if($contactpreference_billing_phone = ArrayHelper::getValue($apiObject, 'contactpreference_billing_phone')) {
            $this->contactpreference_billing_phone = $contactpreference_billing_phone;
        }
        if($contactpreference_billing_sms = ArrayHelper::getValue($apiObject, 'contactpreference_billing_sms')) {
            $this->contactpreference_billing_sms = $contactpreference_billing_sms;
        }
        if($contactpreference_lab_email = ArrayHelper::getValue($apiObject, 'contactpreference_lab_email')) {
            $this->contactpreference_lab_email = $contactpreference_lab_email;
        }
        if($contactpreference_lab_phone = ArrayHelper::getValue($apiObject, 'contactpreference_lab_phone')) {
            $this->contactpreference_lab_phone = $contactpreference_lab_phone;
        }
        if($contactpreference_lab_sms = ArrayHelper::getValue($apiObject, 'contactpreference_lab_sms')) {
            $this->contactpreference_lab_sms = $contactpreference_lab_sms;
        }
        if($contactrelationship = ArrayHelper::getValue($apiObject, 'contactrelationship')) {
            $this->contactrelationship = $contactrelationship;
        }
        if($countrycode3166 = ArrayHelper::getValue($apiObject, 'countrycode3166')) {
            $this->countrycode3166 = $countrycode3166;
        }
        if($deceaseddate = ArrayHelper::getValue($apiObject, 'deceaseddate')) {
            $this->deceaseddate = $deceaseddate;
        }
        if($defaultpharmacyncpdpid = ArrayHelper::getValue($apiObject, 'defaultpharmacyncpdpid')) {
            $this->defaultpharmacyncpdpid = $defaultpharmacyncpdpid;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($dob = ArrayHelper::getValue($apiObject, 'dob')) {
            $this->dob = $dob;
        }
        if($donotcallyn = ArrayHelper::getValue($apiObject, 'donotcallyn')) {
            $this->donotcallyn = $donotcallyn;
        }
        if($driverslicenseexpirationdate = ArrayHelper::getValue($apiObject, 'driverslicenseexpirationdate')) {
            $this->driverslicenseexpirationdate = $driverslicenseexpirationdate;
        }
        if($driverslicensenumber = ArrayHelper::getValue($apiObject, 'driverslicensenumber')) {
            $this->driverslicensenumber = $driverslicensenumber;
        }
        if($driverslicensestateid = ArrayHelper::getValue($apiObject, 'driverslicensestateid')) {
            $this->driverslicensestateid = $driverslicensestateid;
        }
        if($email = ArrayHelper::getValue($apiObject, 'email')) {
            $this->email = $email;
        }
        if($employerid = ArrayHelper::getValue($apiObject, 'employerid')) {
            $this->employerid = $employerid;
        }
        if($employerphone = ArrayHelper::getValue($apiObject, 'employerphone')) {
            $this->employerphone = $employerphone;
        }
        if($ethnicitycode = ArrayHelper::getValue($apiObject, 'ethnicitycode')) {
            $this->ethnicitycode = $ethnicitycode;
        }
        if($firstname = ArrayHelper::getValue($apiObject, 'firstname')) {
            $this->firstname = $firstname;
        }
        if($genderidentity = ArrayHelper::getValue($apiObject, 'genderidentity')) {
            $this->genderidentity = $genderidentity;
        }
        if($genderidentityother = ArrayHelper::getValue($apiObject, 'genderidentityother')) {
            $this->genderidentityother = $genderidentityother;
        }
        if($guarantoraddress1 = ArrayHelper::getValue($apiObject, 'guarantoraddress1')) {
            $this->guarantoraddress1 = $guarantoraddress1;
        }
        if($guarantoraddress2 = ArrayHelper::getValue($apiObject, 'guarantoraddress2')) {
            $this->guarantoraddress2 = $guarantoraddress2;
        }
        if($guarantoraddresssameaspatient = ArrayHelper::getValue($apiObject, 'guarantoraddresssameaspatient')) {
            $this->guarantoraddresssameaspatient = $guarantoraddresssameaspatient;
        }
        if($guarantorcity = ArrayHelper::getValue($apiObject, 'guarantorcity')) {
            $this->guarantorcity = $guarantorcity;
        }
        if($guarantorcountrycode3166 = ArrayHelper::getValue($apiObject, 'guarantorcountrycode3166')) {
            $this->guarantorcountrycode3166 = $guarantorcountrycode3166;
        }
        if($guarantordob = ArrayHelper::getValue($apiObject, 'guarantordob')) {
            $this->guarantordob = $guarantordob;
        }
        if($guarantoremail = ArrayHelper::getValue($apiObject, 'guarantoremail')) {
            $this->guarantoremail = $guarantoremail;
        }
        if($guarantoremployerid = ArrayHelper::getValue($apiObject, 'guarantoremployerid')) {
            $this->guarantoremployerid = $guarantoremployerid;
        }
        if($guarantorfirstname = ArrayHelper::getValue($apiObject, 'guarantorfirstname')) {
            $this->guarantorfirstname = $guarantorfirstname;
        }
        if($guarantorlastname = ArrayHelper::getValue($apiObject, 'guarantorlastname')) {
            $this->guarantorlastname = $guarantorlastname;
        }
        if($guarantormiddlename = ArrayHelper::getValue($apiObject, 'guarantormiddlename')) {
            $this->guarantormiddlename = $guarantormiddlename;
        }
        if($guarantorphone = ArrayHelper::getValue($apiObject, 'guarantorphone')) {
            $this->guarantorphone = $guarantorphone;
        }
        if($guarantorrelationshiptopatient = ArrayHelper::getValue($apiObject, 'guarantorrelationshiptopatient')) {
            $this->guarantorrelationshiptopatient = $guarantorrelationshiptopatient;
        }
        if($guarantorssn = ArrayHelper::getValue($apiObject, 'guarantorssn')) {
            $this->guarantorssn = $guarantorssn;
        }
        if($guarantorstate = ArrayHelper::getValue($apiObject, 'guarantorstate')) {
            $this->guarantorstate = $guarantorstate;
        }
        if($guarantorsuffix = ArrayHelper::getValue($apiObject, 'guarantorsuffix')) {
            $this->guarantorsuffix = $guarantorsuffix;
        }
        if($guarantorzip = ArrayHelper::getValue($apiObject, 'guarantorzip')) {
            $this->guarantorzip = $guarantorzip;
        }
        if($guardianfirstname = ArrayHelper::getValue($apiObject, 'guardianfirstname')) {
            $this->guardianfirstname = $guardianfirstname;
        }
        if($guardianlastname = ArrayHelper::getValue($apiObject, 'guardianlastname')) {
            $this->guardianlastname = $guardianlastname;
        }
        if($guardianmiddlename = ArrayHelper::getValue($apiObject, 'guardianmiddlename')) {
            $this->guardianmiddlename = $guardianmiddlename;
        }
        if($guardiansuffix = ArrayHelper::getValue($apiObject, 'guardiansuffix')) {
            $this->guardiansuffix = $guardiansuffix;
        }
        if($hasmobileyn = ArrayHelper::getValue($apiObject, 'hasmobileyn')) {
            $this->hasmobileyn = $hasmobileyn;
        }
        if($homeboundyn = ArrayHelper::getValue($apiObject, 'homeboundyn')) {
            $this->homeboundyn = $homeboundyn;
        }
        if($homeless = ArrayHelper::getValue($apiObject, 'homeless')) {
            $this->homeless = $homeless;
        }
        if($homelesstype = ArrayHelper::getValue($apiObject, 'homelesstype')) {
            $this->homelesstype = $homelesstype;
        }
        if($homephone = ArrayHelper::getValue($apiObject, 'homephone')) {
            $this->homephone = $homephone;
        }
        if($ignorerestrictions = ArrayHelper::getValue($apiObject, 'ignorerestrictions')) {
            $this->ignorerestrictions = $ignorerestrictions;
        }
        if($industrycode = ArrayHelper::getValue($apiObject, 'industrycode')) {
            $this->industrycode = $industrycode;
        }
        if($language6392code = ArrayHelper::getValue($apiObject, 'language6392code')) {
            $this->language6392code = $language6392code;
        }
        if($lastname = ArrayHelper::getValue($apiObject, 'lastname')) {
            $this->lastname = $lastname;
        }
        if($lookupdepartmentid = ArrayHelper::getValue($apiObject, 'lookupdepartmentid')) {
            $this->lookupdepartmentid = $lookupdepartmentid;
        }
        if($maritalstatus = ArrayHelper::getValue($apiObject, 'maritalstatus')) {
            $this->maritalstatus = $maritalstatus;
        }
        if($middlename = ArrayHelper::getValue($apiObject, 'middlename')) {
            $this->middlename = $middlename;
        }
        if($mobilecarrierid = ArrayHelper::getValue($apiObject, 'mobilecarrierid')) {
            $this->mobilecarrierid = $mobilecarrierid;
        }
        if($mobilephone = ArrayHelper::getValue($apiObject, 'mobilephone')) {
            $this->mobilephone = $mobilephone;
        }
        if($nextkinname = ArrayHelper::getValue($apiObject, 'nextkinname')) {
            $this->nextkinname = $nextkinname;
        }
        if($nextkinphone = ArrayHelper::getValue($apiObject, 'nextkinphone')) {
            $this->nextkinphone = $nextkinphone;
        }
        if($nextkinrelationship = ArrayHelper::getValue($apiObject, 'nextkinrelationship')) {
            $this->nextkinrelationship = $nextkinrelationship;
        }
        if($notes = ArrayHelper::getValue($apiObject, 'notes')) {
            $this->notes = $notes;
        }
        if($occupationcode = ArrayHelper::getValue($apiObject, 'occupationcode')) {
            $this->occupationcode = $occupationcode;
        }
        if($onlinestatementonlyyn = ArrayHelper::getValue($apiObject, 'onlinestatementonlyyn')) {
            $this->onlinestatementonlyyn = $onlinestatementonlyyn;
        }
        if($portalaccessgiven = ArrayHelper::getValue($apiObject, 'portalaccessgiven')) {
            $this->portalaccessgiven = $portalaccessgiven;
        }
        if($povertylevelcalculated = ArrayHelper::getValue($apiObject, 'povertylevelcalculated')) {
            $this->povertylevelcalculated = $povertylevelcalculated;
        }
        if($povertylevelfamilysize = ArrayHelper::getValue($apiObject, 'povertylevelfamilysize')) {
            $this->povertylevelfamilysize = $povertylevelfamilysize;
        }
        if($povertylevelfamilysizedeclined = ArrayHelper::getValue($apiObject, 'povertylevelfamilysizedeclined')) {
            $this->povertylevelfamilysizedeclined = $povertylevelfamilysizedeclined;
        }
        if($povertylevelincomedeclined = ArrayHelper::getValue($apiObject, 'povertylevelincomedeclined')) {
            $this->povertylevelincomedeclined = $povertylevelincomedeclined;
        }
        if($povertylevelincomepayperiod = ArrayHelper::getValue($apiObject, 'povertylevelincomepayperiod')) {
            $this->povertylevelincomepayperiod = $povertylevelincomepayperiod;
        }
        if($povertylevelincomeperpayperiod = ArrayHelper::getValue($apiObject, 'povertylevelincomeperpayperiod')) {
            $this->povertylevelincomeperpayperiod = $povertylevelincomeperpayperiod;
        }
        if($povertylevelincomerangedeclined = ArrayHelper::getValue($apiObject, 'povertylevelincomerangedeclined')) {
            $this->povertylevelincomerangedeclined = $povertylevelincomerangedeclined;
        }
        if($preferredname = ArrayHelper::getValue($apiObject, 'preferredname')) {
            $this->preferredname = $preferredname;
        }
        if($preferredpronouns = ArrayHelper::getValue($apiObject, 'preferredpronouns')) {
            $this->preferredpronouns = $preferredpronouns;
        }
        if($primarydepartmentid = ArrayHelper::getValue($apiObject, 'primarydepartmentid')) {
            $this->primarydepartmentid = $primarydepartmentid;
        }
        if($primaryproviderid = ArrayHelper::getValue($apiObject, 'primaryproviderid')) {
            $this->primaryproviderid = $primaryproviderid;
        }
        if($publichousing = ArrayHelper::getValue($apiObject, 'publichousing')) {
            $this->publichousing = $publichousing;
        }
        if($race = ArrayHelper::getValue($apiObject, 'race')) {
            $this->race = $race;
        }
        if($referralsourceid = ArrayHelper::getValue($apiObject, 'referralsourceid')) {
            $this->referralsourceid = $referralsourceid;
        }
        if($referralsourceother = ArrayHelper::getValue($apiObject, 'referralsourceother')) {
            $this->referralsourceother = $referralsourceother;
        }
        if($registerpatientindepartment = ArrayHelper::getValue($apiObject, 'registerpatientindepartment')) {
            $this->registerpatientindepartment = $registerpatientindepartment;
        }
        if($returnerroroninvalidemail = ArrayHelper::getValue($apiObject, 'returnerroroninvalidemail')) {
            $this->returnerroroninvalidemail = $returnerroroninvalidemail;
        }
        if($schoolbasedhealthcenter = ArrayHelper::getValue($apiObject, 'schoolbasedhealthcenter')) {
            $this->schoolbasedhealthcenter = $schoolbasedhealthcenter;
        }
        if($sex = ArrayHelper::getValue($apiObject, 'sex')) {
            $this->sex = $sex;
        }
        if($sexualorientation = ArrayHelper::getValue($apiObject, 'sexualorientation')) {
            $this->sexualorientation = $sexualorientation;
        }
        if($sexualorientationother = ArrayHelper::getValue($apiObject, 'sexualorientationother')) {
            $this->sexualorientationother = $sexualorientationother;
        }
        if($ssn = ArrayHelper::getValue($apiObject, 'ssn')) {
            $this->ssn = $ssn;
        }
        if($state = ArrayHelper::getValue($apiObject, 'state')) {
            $this->state = $state;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($suffix = ArrayHelper::getValue($apiObject, 'suffix')) {
            $this->suffix = $suffix;
        }
        if($veteran = ArrayHelper::getValue($apiObject, 'veteran')) {
            $this->veteran = $veteran;
        }
        if($workphone = ArrayHelper::getValue($apiObject, 'workphone')) {
            $this->workphone = $workphone;
        }
        if($zip = ArrayHelper::getValue($apiObject, 'zip')) {
            $this->zip = $zip;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
