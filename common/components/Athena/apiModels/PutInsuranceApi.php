<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $adjusterfax CASE POLICY FIELD - Fax for the adjuster on this case policy. Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterfirstname CASE POLICY FIELD - First name of the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterlastname CASE POLICY FIELD - Last name of the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterphone CASE POLICY FIELD - Phone number/other contact info for the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property bool $anotherpartyresponsible CASE POLICY FIELD - Boolean field indicating if another party was responsible for this accident.
 * @property string $autoaccidentstate CASE POLICY FIELD - Two-letter abbreviation for the state in which the auto accident took place. Only meaningful for auto insurance case policies.
 * @property string $caseinjurydate CASE POLICY FIELD - Date of the injury.  Required for auto insurance, legal, and worker's comp case policies. Dates from over a year ago, and dates in the future are not valid.
 * @property int $departmentid If set, we will use the department id in an attempt to add to the local patient.
 * @property string $descriptionofinjury CASE POLICY FIELD - A description of the injury.  Only available for auto insurance and worker's comp case policies.
 * @property string $expirationdate Set the date that the insurance will expire. This is usually a date within the next year and not in the past.
 * @property array $icd10codes CASE POLICY FIELD - See documentation for ICD9CODES.
 * @property array $icd9codes CASE POLICY FIELD - A list of ICD9 accepted diagnosis codes. Please note that setting anything in this field will overwrite the current codes, so if you wish to append a code, please specify all of the preexisting codes in addition to the new one. Only available for worker's comp case policies.
 * @property string $injuredbodypart CASE POLICY FIELD - Text field for describing the injured body part.  Required for auto insurance case policies.  Also available for worker's comp case policies.
 * @property string $insuranceclaimnumber CASE POLICY FIELD - The auto insurance claim number or the worker's comp claim number.  This is required for those types of case policies.
 * @property string $insuranceidnumber ID number for this insurance or case policy.  This is not useful for auto insurance or worker's comp case policies. For those, please use the insuranceclaimnumber field instead.
 * @property string $insurancephone The phone number for the insurance company. Note: This defaults to the insurance package phone number. If this is set, it will override it. Likewise if blanked out, it will go back to default.
 * @property string $insurancepolicyholder Name of the entity who holds this insurance policy. Required if entity type is set to non-person.
 * @property string $insurancepolicyholderaddress1 The first address line of the insurance policy holder.
 * @property string $insurancepolicyholderaddress2 The second address line of the insurance policy holder.
 * @property string $insurancepolicyholdercity The city of the insurance policy holder.
 * @property string $insurancepolicyholdercountrycode The country code (3 letter) of the insurance policy holder. Either this or insurancepolicyholdercountryiso3166 are acceptable.  Defaults to USA.
 * @property string $insurancepolicyholdercountryiso3166 The <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166</a> country code of the insurance policy holder. Either this or insurancepolicyholdercountrycode are acceptable.  Defaults to US.
 * @property string $insurancepolicyholderdob The DOB of the insurance policy holder (mm/dd/yyyy).
 * @property string $insurancepolicyholderfirstname The first name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderlastname The last name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholdermiddlename The middle name of the insurance policy holder.
 * @property string $insurancepolicyholdersex The sex of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderssn The SSN of the insurance policy holder.
 * @property string $insurancepolicyholderstate The state of the insurance policy holder.
 * @property string $insurancepolicyholdersuffix The suffix of the insurance policy holder.
 * @property string $insurancepolicyholderzip The zip of the insurance policy holder.
 * @property string $insuredentitytypeid
 * @property string $issuedate Set the date that the insurance was issued. This is usually a date in the past year and not in the future.
 * @property int $newsequencenumber Update the sequence number. You cannot assign a sequence number to a patient's insurance if that patient already has another insurance active with that sequence number. Additionally, all lower numbered sequence numbers need to be filled before assigning a higher sequence number.
 * @property string $policynumber The insurance group number.  This is sometimes present on an insurance card.
 * @property bool $realtedtoautoaccident CASE POLICY FIELD - Boolean field indicating whether this case policy is related to an auto accident. Required for auto insurance case policies.
 * @property bool $relatedtoemployment CASE POLICY FIELD - Boolean field indicating whether this case policy is related to the patient's employer.  Required for worker's comp case policies.
 * @property bool $relatedtootheraccident CASE POLICY FIELD - Boolean field indicating whether this case policy is related to another accident.  Only available for worker's comp case policies.
 * @property int $relationshiptoinsuredid This patient's relationship to the policy holder (as an ID).  See <a href="/workflows/patient-relationship-mapping"> the mapping</a>. Please note that if this is set to 12, Entity Type must be set to 2.
 * @property string $repricername CASE POLICY FIELD - Name for the repricer.  Only available for worker's comp case policies.
 * @property string $repricerphone CASE POLICY FIELD - Phone number for the repricer.  Only available for worker's comp case policies.
 * @property string $stateofreportedinjury CASE POLICY FIELD - Two-letter state abbreviation for the state this injury was reported in.  Only available for worker's comp case policies.
 */
class PutInsuranceApi extends BaseApiModel
{

    public $adjusterfax;
    public $adjusterfirstname;
    public $adjusterlastname;
    public $adjusterphone;
    public $anotherpartyresponsible;
    public $autoaccidentstate;
    public $caseinjurydate;
    public $departmentid;
    public $descriptionofinjury;
    public $expirationdate;
    public $icd10codes;
    public $icd9codes;
    public $injuredbodypart;
    public $insuranceclaimnumber;
    public $insuranceidnumber;
    public $insurancephone;
    public $insurancepolicyholder;
    public $insurancepolicyholderaddress1;
    public $insurancepolicyholderaddress2;
    public $insurancepolicyholdercity;
    public $insurancepolicyholdercountrycode;
    public $insurancepolicyholdercountryiso3166;
    public $insurancepolicyholderdob;
    public $insurancepolicyholderfirstname;
    public $insurancepolicyholderlastname;
    public $insurancepolicyholdermiddlename;
    public $insurancepolicyholdersex;
    public $insurancepolicyholderssn;
    public $insurancepolicyholderstate;
    public $insurancepolicyholdersuffix;
    public $insurancepolicyholderzip;
    public $insuredentitytypeid;
    public $issuedate;
    public $newsequencenumber;
    public $policynumber;
    public $realtedtoautoaccident;
    public $relatedtoemployment;
    public $relatedtootheraccident;
    public $relationshiptoinsuredid;
    public $repricername;
    public $repricerphone;
    public $stateofreportedinjury;

    public function rules()
    {
        return [
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'autoaccidentstate', 'caseinjurydate', 'descriptionofinjury', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'trim'],
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'autoaccidentstate', 'caseinjurydate', 'descriptionofinjury', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
