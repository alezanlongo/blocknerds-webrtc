<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $adjusterfax CASE POLICY FIELD - Fax for the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterfirstname CASE POLICY FIELD - First name of the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterlastname CASE POLICY FIELD - Last name of the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $adjusterphone CASE POLICY FIELD - Phone number/other contact info for the adjuster on this case policy.  Only available for auto insurance or worker's comp case policies.
 * @property string $anotherpartyresponsibleyn CASE POLICY FIELD - Boolean field indicating if another party was responsible for this accident.
 * @property string $autoaccidentstate CASE POLICY FIELD - Two-letter abbreviation for the state in which the auto accident took place. Only meaningful for auto insurance case policies.
 * @property string $cancelled The date in which the insurance was marked cancelled.
 * @property string $caseinjurydate CASE POLICY FIELD - Date of the injury.  Required for auto insurance, legal, and worker's comp case policies.
 * @property string $casepolicytypename CASE POLICY FIELD - The name of this type of case policy.
 * @property int $ccmstatusid Status ID of current CCM enrollment.
 * @property string $ccmstatusname The name of current CCM enrollment status.
 * @property float $coinsurancepercent The coinsurance percentage for this insurance. If you've just POSTed a new insurance you will have to wait for the auto eligbility check before this field populates.
 * @property string $copays Details about the copays for this insurance package. If you've just POSTed a new insurance you will have to wait for the auto eligbility check before these populate.
 * @property string $descriptionofinjury CASE POLICY FIELD - A description of the injury.  Only available for auto insurance and worker's comp case policies.
 * @property string $eligibilitylastchecked Date the eligibility was last checked.
 * @property string $eligibilitymessage The message, usually from our engine, of the eligibility check.
 * @property string $eligibilityreason The source of the current status. Athena is our eligibility engine.
 * @property string $eligibilitystatus Current eligibility status of this insurance package.
 * @property string $employerid The employer ID associated with the patient's insurance.
 * @property string $expirationdate Date the insurance expires.
 * @property string $icd10codes CASE POLICY FIELD - See documentation for ICD9CODES.
 * @property string $icd9codes CASE POLICY FIELD - A list of ICD9 accepted diagnosis codes. Only available for worker's comp case policies.
 * @property string $injuredbodypart CASE POLICY FIELD - Text field for describing the injured body part.  Only available for auto insurance  and worker's comp case policies.
 * @property string $insuranceclaimnumber CASE POLICY FIELD - The auto insurance claim number or the worker's comp claim number.
 * @property string $insuranceid The athena insurance policy ID.
 * @property string $insuranceidnumber The insurance policy ID number (as presented on the insurance card itself).
 * @property string $insurancepackageaddress1 Address 1 for the AthenaNet insurance Package.
 * @property string $insurancepackageaddress2 Address 2 for the AthenaNet insurance Package.
 * @property string $insurancepackagecity City for the AthenaNet insurance Package.
 * @property int $insurancepackageid The athenaNet insurance package ID.
 * @property string $insurancepackagestate State of the AthenaNet insurance package
 * @property string $insurancepackagezip Zip code of the AthenaNet insurance package
 * @property string $insurancephone The phone number for the insurance company. Note: This defaults to the insurance package phone number. If this is set, it will override it. Likewise if blanked out, it will go back to default.
 * @property string $insuranceplandisplayname Superpackagename of the specific insurance package.
 * @property string $insuranceplanname Name of the specific insurance package.
 * @property string $insurancepolicyholder The full name of the insurance policy holder.
 * @property string $insurancepolicyholderaddress1 The first address line of the insurance policy holder.
 * @property string $insurancepolicyholderaddress2 The second address line of the insurance policy holder.
 * @property string $insurancepolicyholdercity The city of the insurance policy holder.
 * @property string $insurancepolicyholdercountrycode The country code (3 letter) of the insurance policy holder.
 * @property string $insurancepolicyholdercountryiso3166 The <a href="http://en.wikipedia.org/wiki/ISO_3166-1_alpha-2">ISO 3166</a> country code of the insurance policy holder.
 * @property string $insurancepolicyholderdob The DOB of the insurance policy holder (mm/dd/yyyy).
 * @property string $insurancepolicyholderfirstname The first name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderlastname The last name of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholdermiddlename The middle name of the insurance policy holder.
 * @property string $insurancepolicyholdersex The sex of the insurance policy holder.  Except for self-pay, required for new policies.
 * @property string $insurancepolicyholderssn The SSN of the insurance policy holder.
 * @property string $insurancepolicyholderstate The state of the insurance policy holder.
 * @property string $insurancepolicyholdersuffix The suffix of the insurance policy holder.
 * @property string $insurancepolicyholderzip The zip of the insurance policy holder.
 * @property string $insurancetype Type of insurance. E.g., Medicare Part B, Group Policy, HMO, etc.
 * @property int $insuredentitytypeid The ID of the entity type for this insurance.
 * @property string $insuredpcp
 * @property int $insuredpcpnpi The national provider id of the primary care physcian assicated with the insurance.
 * @property int $ircid Insurance category / company internal ID
 * @property string $ircname Insurance category / company. E.g., United Healthcare, BCBS-MA, etc.
 * @property string $issuedate Date the insurance was issued.
 * @property string $policynumber The insurance group number.  This is sometimes present on an insurance card.
 * @property string $relatedtoautoaccidentyn CASE POLICY FIELD - Boolean field indicating whether this case policy is related to an auto accident.
 * @property string $relatedtoemploymentyn CASE POLICY FIELD - Boolean field indicating whether this case policy is related to the patient's employer.
 * @property string $relatedtootheraccidentyn CASE POLICY FIELD - Boolean field indicating whether this case policy is related to another accident.  Only available for worker's comp case policies.
 * @property string $relationshiptoinsured This patient's relationship to the policy holder (text).
 * @property int $relationshiptoinsuredid This patient's relationship to the policy holder (as an ID).  See <a href="/workflows/patient-relationship-mapping">the mapping</a>.
 * @property string $repricername CASE POLICY FIELD - Name for the repricer.  Only available for worker's comp case policies.
 * @property string $repricerphone CASE POLICY FIELD - Phone number for the repricer.  Only available for worker's comp case policies.
 * @property int $sequencenumber 1 = primary, 2 = secondary, 3 = tertiary, etc.  Must have a primary before a secondary and a secondary before a tertiary, etc.
 * @property int $slidingfeeplanid If the patient is on a sliding fee plan, this is the ID of that plan.  See /slidingfeeplans.
 * @property string $stateofreportedinjury CASE POLICY FIELD - Two-letter state abbreviation for the state this injury was reported in.  Only available for worker's comp case policies.
 */
class InsurancePatientApi extends Model
{

    public $adjusterfax;
    public $adjusterfirstname;
    public $adjusterlastname;
    public $adjusterphone;
    public $anotherpartyresponsibleyn;
    public $autoaccidentstate;
    public $cancelled;
    public $caseinjurydate;
    public $casepolicytypename;
    public $ccmstatusid;
    public $ccmstatusname;
    public $coinsurancepercent;
    public $copays;
    public $descriptionofinjury;
    public $eligibilitylastchecked;
    public $eligibilitymessage;
    public $eligibilityreason;
    public $eligibilitystatus;
    public $employerid;
    public $expirationdate;
    public $icd10codes;
    public $icd9codes;
    public $injuredbodypart;
    public $insuranceclaimnumber;
    public $insuranceid;
    public $insuranceidnumber;
    public $insurancepackageaddress1;
    public $insurancepackageaddress2;
    public $insurancepackagecity;
    public $insurancepackageid;
    public $insurancepackagestate;
    public $insurancepackagezip;
    public $insurancephone;
    public $insuranceplandisplayname;
    public $insuranceplanname;
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
    public $insurancetype;
    public $insuredentitytypeid;
    public $insuredpcp;
    public $insuredpcpnpi;
    public $ircid;
    public $ircname;
    public $issuedate;
    public $policynumber;
    public $relatedtoautoaccidentyn;
    public $relatedtoemploymentyn;
    public $relatedtootheraccidentyn;
    public $relationshiptoinsured;
    public $relationshiptoinsuredid;
    public $repricername;
    public $repricerphone;
    public $sequencenumber;
    public $slidingfeeplanid;
    public $stateofreportedinjury;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function rules()
    {
        return [
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'anotherpartyresponsibleyn', 'autoaccidentstate', 'cancelled', 'caseinjurydate', 'casepolicytypename', 'ccmstatusname', 'copays', 'descriptionofinjury', 'eligibilitylastchecked', 'eligibilitymessage', 'eligibilityreason', 'eligibilitystatus', 'employerid', 'expirationdate', 'icd10codes', 'icd9codes', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceid', 'insuranceidnumber', 'insurancepackageaddress1', 'insurancepackageaddress2', 'insurancepackagecity', 'insurancepackagestate', 'insurancepackagezip', 'insurancephone', 'insuranceplandisplayname', 'insuranceplanname', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insurancetype', 'insuredpcp', 'ircname', 'issuedate', 'policynumber', 'relatedtoautoaccidentyn', 'relatedtoemploymentyn', 'relatedtootheraccidentyn', 'relationshiptoinsured', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'trim'],
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'anotherpartyresponsibleyn', 'autoaccidentstate', 'cancelled', 'caseinjurydate', 'casepolicytypename', 'ccmstatusname', 'copays', 'descriptionofinjury', 'eligibilitylastchecked', 'eligibilitymessage', 'eligibilityreason', 'eligibilitystatus', 'employerid', 'expirationdate', 'icd10codes', 'icd9codes', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceid', 'insuranceidnumber', 'insurancepackageaddress1', 'insurancepackageaddress2', 'insurancepackagecity', 'insurancepackagestate', 'insurancepackagezip', 'insurancephone', 'insuranceplandisplayname', 'insuranceplanname', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insurancetype', 'insuredpcp', 'ircname', 'issuedate', 'policynumber', 'relatedtoautoaccidentyn', 'relatedtoemploymentyn', 'relatedtootheraccidentyn', 'relationshiptoinsured', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
