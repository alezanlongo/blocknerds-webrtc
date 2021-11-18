<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $approvedby For clinical prescriptions, the athenaNet username of the person who approved this prescription.
 * @property string $billingndc The billing NDC code for this medication.
 * @property int $chartsharinggroupid The chart charing group for this medication. For more information on chart sharing groups see /configuration/chartsharinggroups.
 * @property string $createdby The athenaNet username of the person who entered or ordered the medication. Downloaded medications have INTERFACE for this field.
 * @property string $deletedby The athenaNet username of the person who deleted the medication.
 * @property string $earliestfilldate The earliest date a prescription may be filled, in the format mm/dd/yyyy.
 * @property int $encounterid If this was a prescription, this contains the ID of the encounter where it was ordered or administered
 * @property string $futuresubmitdate The date a medication will be submitted. Included if the medication is in PEND status and attached to a approved future order.
 * @property string $issafetorenew
 * @property string $isstructuredsig Whether the sig for this entry is structured.
 * @property string $lastupdated The last time any of the medications were updated
 * @property string $medication The name of the medication.
 * @property string $medicationentryid Primary ID for this medication entry. Those starting with C are clinical prescriptions, and those starting with H are historical (entered, downloaded, etc).
 * @property int $medicationid Athena ID for this medication.
 * @property string $ndcoptions The list of NDC numbers that correspond to this medication.
 * @property string $orderingmode The ordering mode for prescriptions. Can be PRESCRIBE, DISPENSE, or ADMINISTER.
 * @property string $organclass The organ class for this medication. This is equivalent to a medication class.
 * @property int $patientid The patient that this medication was prescribed to.
 * @property string $patientnote Patient-facing note for this prescription. Labeled "note" in the UI.
 * @property string $pharmacy The name of the pharmacy where this medication was filled.
 * @property string $pharmacyncpdpid The NCPDP ID of the pharmacy for this medication..  See http://www.ncpdp.org/ for details.
 * @property string $prescribedby The user who prescribed this medication.
 * @property string $providernote Non-patient facing note for ths prescription. Labeled "internal note" in the UI.
 * @property int $refillsallowed The number of refills allowed when this medication was ordered.
 * @property string $route The route for the prescription.
 * @property string $rxnorm The list of RxNorm Identifiers that correspond to this medication. This list may contain both branded and generic identifiers. Note: Not All medications would include RX Norm.
 * @property string $source How this medication was entered. This can be the ordering provider, a medication history download (express scripts, medco, etc), ATHENA (which means it was entered manually), etc.
 * @property string $status The status of this medication. Medications in PEND status are associated with approved future orders and have not yet been submitted.
 * @property string $stopreason The reason why this medication was stopped.
 * @property string $therapeuticclass The therapeutic class for this medication. This is equivalent to a medication subclass.
 * @property string $unstructuredsig The unstructured sig for this medication, if any. If there is a structured sig, this will contain the formatted version of that sig.
 * @property integer $patient_id
 * @property Patient $patient
 * @property string $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Medication extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%medications}}';
    }

    public function rules()
    {
        return [
            [['approvedby', 'billingndc', 'createdby', 'deletedby', 'earliestfilldate', 'futuresubmitdate', 'issafetorenew', 'isstructuredsig', 'lastupdated', 'medication', 'medicationentryid', 'ndcoptions', 'orderingmode', 'organclass', 'patientnote', 'pharmacy', 'pharmacyncpdpid', 'prescribedby', 'providernote', 'route', 'rxnorm', 'source', 'status', 'stopreason', 'therapeuticclass', 'unstructuredsig', 'externalId'], 'trim'],
            [['approvedby', 'billingndc', 'createdby', 'deletedby', 'earliestfilldate', 'futuresubmitdate', 'issafetorenew', 'isstructuredsig', 'lastupdated', 'medication', 'medicationentryid', 'ndcoptions', 'orderingmode', 'organclass', 'patientnote', 'pharmacy', 'pharmacyncpdpid', 'prescribedby', 'providernote', 'route', 'rxnorm', 'source', 'status', 'stopreason', 'therapeuticclass', 'unstructuredsig', 'externalId'], 'string'],
            [['chartsharinggroupid', 'encounterid', 'medicationid', 'patientid', 'refillsallowed', 'patient_id', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($approvedby = ArrayHelper::getValue($apiObject, 'approvedby')) {
            $this->approvedby = $approvedby;
        }
        if($billingndc = ArrayHelper::getValue($apiObject, 'billingndc')) {
            $this->billingndc = $billingndc;
        }
        if($chartsharinggroupid = ArrayHelper::getValue($apiObject, 'chartsharinggroupid')) {
            $this->chartsharinggroupid = $chartsharinggroupid;
        }
        if($createdby = ArrayHelper::getValue($apiObject, 'createdby')) {
            $this->createdby = $createdby;
        }
        if($deletedby = ArrayHelper::getValue($apiObject, 'deletedby')) {
            $this->deletedby = $deletedby;
        }
        if($earliestfilldate = ArrayHelper::getValue($apiObject, 'earliestfilldate')) {
            $this->earliestfilldate = $earliestfilldate;
        }
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->encounterid = $encounterid;
        }
        if($futuresubmitdate = ArrayHelper::getValue($apiObject, 'futuresubmitdate')) {
            $this->futuresubmitdate = $futuresubmitdate;
        }
        if($issafetorenew = ArrayHelper::getValue($apiObject, 'issafetorenew')) {
            $this->issafetorenew = $issafetorenew;
        }
        if($isstructuredsig = ArrayHelper::getValue($apiObject, 'isstructuredsig')) {
            $this->isstructuredsig = $isstructuredsig;
        }
        if($lastupdated = ArrayHelper::getValue($apiObject, 'lastupdated')) {
            $this->lastupdated = $lastupdated;
        }
        if($medication = ArrayHelper::getValue($apiObject, 'medication')) {
            $this->medication = $medication;
        }
        if($medicationentryid = ArrayHelper::getValue($apiObject, 'medicationentryid')) {
            $this->medicationentryid = $medicationentryid;
        }
        if($medicationentryid = ArrayHelper::getValue($apiObject, 'medicationentryid')) {
            $this->externalId = $medicationentryid;
        }
        if($medicationid = ArrayHelper::getValue($apiObject, 'medicationid')) {
            $this->medicationid = $medicationid;
        }
        if($ndcoptions = ArrayHelper::getValue($apiObject, 'ndcoptions')) {
            $this->ndcoptions = $ndcoptions;
        }
        if($orderingmode = ArrayHelper::getValue($apiObject, 'orderingmode')) {
            $this->orderingmode = $orderingmode;
        }
        if($organclass = ArrayHelper::getValue($apiObject, 'organclass')) {
            $this->organclass = $organclass;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($patientnote = ArrayHelper::getValue($apiObject, 'patientnote')) {
            $this->patientnote = $patientnote;
        }
        if($pharmacy = ArrayHelper::getValue($apiObject, 'pharmacy')) {
            $this->pharmacy = $pharmacy;
        }
        if($pharmacyncpdpid = ArrayHelper::getValue($apiObject, 'pharmacyncpdpid')) {
            $this->pharmacyncpdpid = $pharmacyncpdpid;
        }
        if($prescribedby = ArrayHelper::getValue($apiObject, 'prescribedby')) {
            $this->prescribedby = $prescribedby;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
        }
        if($refillsallowed = ArrayHelper::getValue($apiObject, 'refillsallowed')) {
            $this->refillsallowed = $refillsallowed;
        }
        if($route = ArrayHelper::getValue($apiObject, 'route')) {
            $this->route = $route;
        }
        if($rxnorm = ArrayHelper::getValue($apiObject, 'rxnorm')) {
            $this->rxnorm = $rxnorm;
        }
        if($source = ArrayHelper::getValue($apiObject, 'source')) {
            $this->source = $source;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($stopreason = ArrayHelper::getValue($apiObject, 'stopreason')) {
            $this->stopreason = $stopreason;
        }
        if($therapeuticclass = ArrayHelper::getValue($apiObject, 'therapeuticclass')) {
            $this->therapeuticclass = $therapeuticclass;
        }
        if($unstructuredsig = ArrayHelper::getValue($apiObject, 'unstructuredsig')) {
            $this->unstructuredsig = $unstructuredsig;
        }
        if($patient_id = ArrayHelper::getValue($apiObject, 'patient_id')) {
            $this->patient_id = $patient_id;
        }
        if($patient = ArrayHelper::getValue($apiObject, 'patient')) {
            $this->patient = $patient;
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
