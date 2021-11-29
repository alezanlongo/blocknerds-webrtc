<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutInsurance extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_insurances}}';
    }

    public function rules()
    {
        return [
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'autoaccidentstate', 'caseinjurydate', 'descriptionofinjury', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'trim'],
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'autoaccidentstate', 'caseinjurydate', 'descriptionofinjury', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceidnumber', 'insurancephone', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insuredentitytypeid', 'issuedate', 'policynumber', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'string'],
            [['departmentid', 'newsequencenumber', 'relationshiptoinsuredid', 'externalId', 'id'], 'integer'],
            [['anotherpartyresponsible', 'realtedtoautoaccident', 'relatedtoemployment', 'relatedtootheraccident'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($adjusterfax = ArrayHelper::getValue($apiObject, 'adjusterfax')) {
            $this->adjusterfax = $adjusterfax;
        }
        if($adjusterfirstname = ArrayHelper::getValue($apiObject, 'adjusterfirstname')) {
            $this->adjusterfirstname = $adjusterfirstname;
        }
        if($adjusterlastname = ArrayHelper::getValue($apiObject, 'adjusterlastname')) {
            $this->adjusterlastname = $adjusterlastname;
        }
        if($adjusterphone = ArrayHelper::getValue($apiObject, 'adjusterphone')) {
            $this->adjusterphone = $adjusterphone;
        }
        if($anotherpartyresponsible = ArrayHelper::getValue($apiObject, 'anotherpartyresponsible')) {
            $this->anotherpartyresponsible = $anotherpartyresponsible;
        }
        if($autoaccidentstate = ArrayHelper::getValue($apiObject, 'autoaccidentstate')) {
            $this->autoaccidentstate = $autoaccidentstate;
        }
        if($caseinjurydate = ArrayHelper::getValue($apiObject, 'caseinjurydate')) {
            $this->caseinjurydate = $caseinjurydate;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($descriptionofinjury = ArrayHelper::getValue($apiObject, 'descriptionofinjury')) {
            $this->descriptionofinjury = $descriptionofinjury;
        }
        if($expirationdate = ArrayHelper::getValue($apiObject, 'expirationdate')) {
            $this->expirationdate = $expirationdate;
        }
        if($icd10codes = ArrayHelper::getValue($apiObject, 'icd10codes')) {
            $this->icd10codes = $icd10codes;
        }
        if($icd9codes = ArrayHelper::getValue($apiObject, 'icd9codes')) {
            $this->icd9codes = $icd9codes;
        }
        if($injuredbodypart = ArrayHelper::getValue($apiObject, 'injuredbodypart')) {
            $this->injuredbodypart = $injuredbodypart;
        }
        if($insuranceclaimnumber = ArrayHelper::getValue($apiObject, 'insuranceclaimnumber')) {
            $this->insuranceclaimnumber = $insuranceclaimnumber;
        }
        if($insuranceidnumber = ArrayHelper::getValue($apiObject, 'insuranceidnumber')) {
            $this->insuranceidnumber = $insuranceidnumber;
        }
        if($insurancephone = ArrayHelper::getValue($apiObject, 'insurancephone')) {
            $this->insurancephone = $insurancephone;
        }
        if($insurancepolicyholder = ArrayHelper::getValue($apiObject, 'insurancepolicyholder')) {
            $this->insurancepolicyholder = $insurancepolicyholder;
        }
        if($insurancepolicyholderaddress1 = ArrayHelper::getValue($apiObject, 'insurancepolicyholderaddress1')) {
            $this->insurancepolicyholderaddress1 = $insurancepolicyholderaddress1;
        }
        if($insurancepolicyholderaddress2 = ArrayHelper::getValue($apiObject, 'insurancepolicyholderaddress2')) {
            $this->insurancepolicyholderaddress2 = $insurancepolicyholderaddress2;
        }
        if($insurancepolicyholdercity = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercity')) {
            $this->insurancepolicyholdercity = $insurancepolicyholdercity;
        }
        if($insurancepolicyholdercountrycode = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercountrycode')) {
            $this->insurancepolicyholdercountrycode = $insurancepolicyholdercountrycode;
        }
        if($insurancepolicyholdercountryiso3166 = ArrayHelper::getValue($apiObject, 'insurancepolicyholdercountryiso3166')) {
            $this->insurancepolicyholdercountryiso3166 = $insurancepolicyholdercountryiso3166;
        }
        if($insurancepolicyholderdob = ArrayHelper::getValue($apiObject, 'insurancepolicyholderdob')) {
            $this->insurancepolicyholderdob = $insurancepolicyholderdob;
        }
        if($insurancepolicyholderfirstname = ArrayHelper::getValue($apiObject, 'insurancepolicyholderfirstname')) {
            $this->insurancepolicyholderfirstname = $insurancepolicyholderfirstname;
        }
        if($insurancepolicyholderlastname = ArrayHelper::getValue($apiObject, 'insurancepolicyholderlastname')) {
            $this->insurancepolicyholderlastname = $insurancepolicyholderlastname;
        }
        if($insurancepolicyholdermiddlename = ArrayHelper::getValue($apiObject, 'insurancepolicyholdermiddlename')) {
            $this->insurancepolicyholdermiddlename = $insurancepolicyholdermiddlename;
        }
        if($insurancepolicyholdersex = ArrayHelper::getValue($apiObject, 'insurancepolicyholdersex')) {
            $this->insurancepolicyholdersex = $insurancepolicyholdersex;
        }
        if($insurancepolicyholderssn = ArrayHelper::getValue($apiObject, 'insurancepolicyholderssn')) {
            $this->insurancepolicyholderssn = $insurancepolicyholderssn;
        }
        if($insurancepolicyholderstate = ArrayHelper::getValue($apiObject, 'insurancepolicyholderstate')) {
            $this->insurancepolicyholderstate = $insurancepolicyholderstate;
        }
        if($insurancepolicyholdersuffix = ArrayHelper::getValue($apiObject, 'insurancepolicyholdersuffix')) {
            $this->insurancepolicyholdersuffix = $insurancepolicyholdersuffix;
        }
        if($insurancepolicyholderzip = ArrayHelper::getValue($apiObject, 'insurancepolicyholderzip')) {
            $this->insurancepolicyholderzip = $insurancepolicyholderzip;
        }
        if($insuredentitytypeid = ArrayHelper::getValue($apiObject, 'insuredentitytypeid')) {
            $this->insuredentitytypeid = $insuredentitytypeid;
        }
        if($issuedate = ArrayHelper::getValue($apiObject, 'issuedate')) {
            $this->issuedate = $issuedate;
        }
        if($newsequencenumber = ArrayHelper::getValue($apiObject, 'newsequencenumber')) {
            $this->newsequencenumber = $newsequencenumber;
        }
        if($policynumber = ArrayHelper::getValue($apiObject, 'policynumber')) {
            $this->policynumber = $policynumber;
        }
        if($realtedtoautoaccident = ArrayHelper::getValue($apiObject, 'realtedtoautoaccident')) {
            $this->realtedtoautoaccident = $realtedtoautoaccident;
        }
        if($relatedtoemployment = ArrayHelper::getValue($apiObject, 'relatedtoemployment')) {
            $this->relatedtoemployment = $relatedtoemployment;
        }
        if($relatedtootheraccident = ArrayHelper::getValue($apiObject, 'relatedtootheraccident')) {
            $this->relatedtootheraccident = $relatedtootheraccident;
        }
        if($relationshiptoinsuredid = ArrayHelper::getValue($apiObject, 'relationshiptoinsuredid')) {
            $this->relationshiptoinsuredid = $relationshiptoinsuredid;
        }
        if($repricername = ArrayHelper::getValue($apiObject, 'repricername')) {
            $this->repricername = $repricername;
        }
        if($repricerphone = ArrayHelper::getValue($apiObject, 'repricerphone')) {
            $this->repricerphone = $repricerphone;
        }
        if($stateofreportedinjury = ArrayHelper::getValue($apiObject, 'stateofreportedinjury')) {
            $this->stateofreportedinjury = $stateofreportedinjury;
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
