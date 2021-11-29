<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $patient_id
 * @property Patient $patient
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
 * @property Copays[] $copays Details about the copays for this insurance package. If you've just POSTed a new insurance you will have to wait for the auto eligbility check before these populate.
 * @property string $descriptionofinjury CASE POLICY FIELD - A description of the injury.  Only available for auto insurance and worker's comp case policies.
 * @property string $eligibilitylastchecked Date the eligibility was last checked.
 * @property string $eligibilitymessage The message, usually from our engine, of the eligibility check.
 * @property string $eligibilityreason The source of the current status. Athena is our eligibility engine.
 * @property string $eligibilitystatus Current eligibility status of this insurance package.
 * @property string $employerid The employer ID associated with the patient's insurance.
 * @property string $expirationdate Date the insurance expires.
 * @property array $icd10codes CASE POLICY FIELD - See documentation for ICD9CODES.
 * @property array $icd9codes CASE POLICY FIELD - A list of ICD9 accepted diagnosis codes. Only available for worker's comp case policies.
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PatientInsurance extends \yii\db\ActiveRecord
{
 
    protected $_copaysAr;

    public static function tableName()
    {
        return '{{%patient_insurances}}';
    }

    public function rules()
    {
        return [
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'anotherpartyresponsibleyn', 'autoaccidentstate', 'cancelled', 'caseinjurydate', 'casepolicytypename', 'ccmstatusname', 'descriptionofinjury', 'eligibilitylastchecked', 'eligibilitymessage', 'eligibilityreason', 'eligibilitystatus', 'employerid', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceid', 'insuranceidnumber', 'insurancepackageaddress1', 'insurancepackageaddress2', 'insurancepackagecity', 'insurancepackagestate', 'insurancepackagezip', 'insurancephone', 'insuranceplandisplayname', 'insuranceplanname', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insurancetype', 'insuredpcp', 'ircname', 'issuedate', 'policynumber', 'relatedtoautoaccidentyn', 'relatedtoemploymentyn', 'relatedtootheraccidentyn', 'relationshiptoinsured', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'trim'],
            [['adjusterfax', 'adjusterfirstname', 'adjusterlastname', 'adjusterphone', 'anotherpartyresponsibleyn', 'autoaccidentstate', 'cancelled', 'caseinjurydate', 'casepolicytypename', 'ccmstatusname', 'descriptionofinjury', 'eligibilitylastchecked', 'eligibilitymessage', 'eligibilityreason', 'eligibilitystatus', 'employerid', 'expirationdate', 'injuredbodypart', 'insuranceclaimnumber', 'insuranceid', 'insuranceidnumber', 'insurancepackageaddress1', 'insurancepackageaddress2', 'insurancepackagecity', 'insurancepackagestate', 'insurancepackagezip', 'insurancephone', 'insuranceplandisplayname', 'insuranceplanname', 'insurancepolicyholder', 'insurancepolicyholderaddress1', 'insurancepolicyholderaddress2', 'insurancepolicyholdercity', 'insurancepolicyholdercountrycode', 'insurancepolicyholdercountryiso3166', 'insurancepolicyholderdob', 'insurancepolicyholderfirstname', 'insurancepolicyholderlastname', 'insurancepolicyholdermiddlename', 'insurancepolicyholdersex', 'insurancepolicyholderssn', 'insurancepolicyholderstate', 'insurancepolicyholdersuffix', 'insurancepolicyholderzip', 'insurancetype', 'insuredpcp', 'ircname', 'issuedate', 'policynumber', 'relatedtoautoaccidentyn', 'relatedtoemploymentyn', 'relatedtootheraccidentyn', 'relationshiptoinsured', 'repricername', 'repricerphone', 'stateofreportedinjury'], 'string'],
            [['patient_id', 'ccmstatusid', 'insurancepackageid', 'insuredentitytypeid', 'insuredpcpnpi', 'ircid', 'relationshiptoinsuredid', 'sequencenumber', 'slidingfeeplanid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }

    public function getCopays()
    {
        return $this->hasMany(Copays::class, ['patient_insurance_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($patient_id = ArrayHelper::getValue($apiObject, 'patient_id')) {
            $this->patient_id = $patient_id;
        }
        if($patient = ArrayHelper::getValue($apiObject, 'patient')) {
            $this->patient = $patient;
        }
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
        if($anotherpartyresponsibleyn = ArrayHelper::getValue($apiObject, 'anotherpartyresponsibleyn')) {
            $this->anotherpartyresponsibleyn = $anotherpartyresponsibleyn;
        }
        if($autoaccidentstate = ArrayHelper::getValue($apiObject, 'autoaccidentstate')) {
            $this->autoaccidentstate = $autoaccidentstate;
        }
        if($cancelled = ArrayHelper::getValue($apiObject, 'cancelled')) {
            $this->cancelled = $cancelled;
        }
        if($caseinjurydate = ArrayHelper::getValue($apiObject, 'caseinjurydate')) {
            $this->caseinjurydate = $caseinjurydate;
        }
        if($casepolicytypename = ArrayHelper::getValue($apiObject, 'casepolicytypename')) {
            $this->casepolicytypename = $casepolicytypename;
        }
        if($ccmstatusid = ArrayHelper::getValue($apiObject, 'ccmstatusid')) {
            $this->ccmstatusid = $ccmstatusid;
        }
        if($ccmstatusname = ArrayHelper::getValue($apiObject, 'ccmstatusname')) {
            $this->ccmstatusname = $ccmstatusname;
        }
        if($coinsurancepercent = ArrayHelper::getValue($apiObject, 'coinsurancepercent')) {
            $this->coinsurancepercent = $coinsurancepercent;
        }
        if($copays = ArrayHelper::getValue($apiObject, 'copays')) {
            $this->_copaysAr = $copays;
        }
        if($descriptionofinjury = ArrayHelper::getValue($apiObject, 'descriptionofinjury')) {
            $this->descriptionofinjury = $descriptionofinjury;
        }
        if($eligibilitylastchecked = ArrayHelper::getValue($apiObject, 'eligibilitylastchecked')) {
            $this->eligibilitylastchecked = $eligibilitylastchecked;
        }
        if($eligibilitymessage = ArrayHelper::getValue($apiObject, 'eligibilitymessage')) {
            $this->eligibilitymessage = $eligibilitymessage;
        }
        if($eligibilityreason = ArrayHelper::getValue($apiObject, 'eligibilityreason')) {
            $this->eligibilityreason = $eligibilityreason;
        }
        if($eligibilitystatus = ArrayHelper::getValue($apiObject, 'eligibilitystatus')) {
            $this->eligibilitystatus = $eligibilitystatus;
        }
        if($employerid = ArrayHelper::getValue($apiObject, 'employerid')) {
            $this->employerid = $employerid;
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
        if($insuranceid = ArrayHelper::getValue($apiObject, 'insuranceid')) {
            $this->insuranceid = $insuranceid;
        }
        if($insuranceid = ArrayHelper::getValue($apiObject, 'insuranceid')) {
            $this->externalId = $insuranceid;
        }
        if($insuranceidnumber = ArrayHelper::getValue($apiObject, 'insuranceidnumber')) {
            $this->insuranceidnumber = $insuranceidnumber;
        }
        if($insurancepackageaddress1 = ArrayHelper::getValue($apiObject, 'insurancepackageaddress1')) {
            $this->insurancepackageaddress1 = $insurancepackageaddress1;
        }
        if($insurancepackageaddress2 = ArrayHelper::getValue($apiObject, 'insurancepackageaddress2')) {
            $this->insurancepackageaddress2 = $insurancepackageaddress2;
        }
        if($insurancepackagecity = ArrayHelper::getValue($apiObject, 'insurancepackagecity')) {
            $this->insurancepackagecity = $insurancepackagecity;
        }
        if($insurancepackageid = ArrayHelper::getValue($apiObject, 'insurancepackageid')) {
            $this->insurancepackageid = $insurancepackageid;
        }
        if($insurancepackagestate = ArrayHelper::getValue($apiObject, 'insurancepackagestate')) {
            $this->insurancepackagestate = $insurancepackagestate;
        }
        if($insurancepackagezip = ArrayHelper::getValue($apiObject, 'insurancepackagezip')) {
            $this->insurancepackagezip = $insurancepackagezip;
        }
        if($insurancephone = ArrayHelper::getValue($apiObject, 'insurancephone')) {
            $this->insurancephone = $insurancephone;
        }
        if($insuranceplandisplayname = ArrayHelper::getValue($apiObject, 'insuranceplandisplayname')) {
            $this->insuranceplandisplayname = $insuranceplandisplayname;
        }
        if($insuranceplanname = ArrayHelper::getValue($apiObject, 'insuranceplanname')) {
            $this->insuranceplanname = $insuranceplanname;
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
        if($insurancetype = ArrayHelper::getValue($apiObject, 'insurancetype')) {
            $this->insurancetype = $insurancetype;
        }
        if($insuredentitytypeid = ArrayHelper::getValue($apiObject, 'insuredentitytypeid')) {
            $this->insuredentitytypeid = $insuredentitytypeid;
        }
        if($insuredpcp = ArrayHelper::getValue($apiObject, 'insuredpcp')) {
            $this->insuredpcp = $insuredpcp;
        }
        if($insuredpcpnpi = ArrayHelper::getValue($apiObject, 'insuredpcpnpi')) {
            $this->insuredpcpnpi = $insuredpcpnpi;
        }
        if($ircid = ArrayHelper::getValue($apiObject, 'ircid')) {
            $this->ircid = $ircid;
        }
        if($ircname = ArrayHelper::getValue($apiObject, 'ircname')) {
            $this->ircname = $ircname;
        }
        if($issuedate = ArrayHelper::getValue($apiObject, 'issuedate')) {
            $this->issuedate = $issuedate;
        }
        if($policynumber = ArrayHelper::getValue($apiObject, 'policynumber')) {
            $this->policynumber = $policynumber;
        }
        if($relatedtoautoaccidentyn = ArrayHelper::getValue($apiObject, 'relatedtoautoaccidentyn')) {
            $this->relatedtoautoaccidentyn = $relatedtoautoaccidentyn;
        }
        if($relatedtoemploymentyn = ArrayHelper::getValue($apiObject, 'relatedtoemploymentyn')) {
            $this->relatedtoemploymentyn = $relatedtoemploymentyn;
        }
        if($relatedtootheraccidentyn = ArrayHelper::getValue($apiObject, 'relatedtootheraccidentyn')) {
            $this->relatedtootheraccidentyn = $relatedtootheraccidentyn;
        }
        if($relationshiptoinsured = ArrayHelper::getValue($apiObject, 'relationshiptoinsured')) {
            $this->relationshiptoinsured = $relationshiptoinsured;
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
        if($sequencenumber = ArrayHelper::getValue($apiObject, 'sequencenumber')) {
            $this->sequencenumber = $sequencenumber;
        }
        if($slidingfeeplanid = ArrayHelper::getValue($apiObject, 'slidingfeeplanid')) {
            $this->slidingfeeplanid = $slidingfeeplanid;
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
        if( !empty($this->_copaysAr) and is_array($this->_copaysAr) ) {
            foreach($this->_copaysAr as $copaysApi) {
                $copays = new Copays();
                $copays->loadApiObject($copaysApi);
                $copays->link('patientInsurance', $this);
                $copays->save();
            }
        }

        return $saved;
    }
    */
}
