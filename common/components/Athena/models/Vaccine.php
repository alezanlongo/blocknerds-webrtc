<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $administerdate Date when this vaccine was administered (if administered). Can be in YYYY, MM/YYYY, or MM/DD/YYYY format.
 * @property string $administernote Note associated with administering the vaccine, if available
 * @property string $administerroute Route by which this vaccine was administered
 * @property string $administerroutedescription Description of the route by which this vaccine was administered
 * @property string $administersite Site where the vaccine was administered
 * @property float $amount Quantity of the vaccine that was adminsitered
 * @property string $approvedby The username of the user who approved this vaccine order, if clinical
 * @property string $approveddate Date when this vaccine order was approved, if clinical
 * @property int $chartsharinggroupid ID of the chart sharing group that the vaccine is associated with. This can be used to determine what department a vaccine belongs with.
 * @property ClinicalOrderClass[] $clinicalorderclasses The various Clinical Order Classes associated with this Vaccine
 * @property ContraindicationReason[] $contraindicationreason List of codes indicating why the order was contraindicated (for vaccines only). If this field is not present, the order does not contain a contraindication reason.
 * @property int $cvx Vaccine Administered Code
 * @property DeclinedReason[] $declinedreason List of codes indicating why the order was not given. If this field is not present, the order was not declined. If the array is empty, no reason has been chosen.
 * @property string $declinedreasontext The user-facing description of the reason the order was not given.
 * @property string $deleteddate Date when this vaccine was deleted (if deleted)
 * @property string $description Vaccine description
 * @property string $enteredby The username of the user who entered the historic vaccine information into the chart
 * @property string $entereddate Date when the vaccine information was entered into the chart
 * @property string $expirationdate Date to administer vaccine by
 * @property string $genusname The name of the vaccine that appears in the UI of the chart
 * @property string $lotnumber The lot number of the vaccine that was administered. This is an identifier assigned to a batch of medications by the manufacturer.
 * @property string $mvx Manufacturer code
 * @property string $ndc The National Drug Code for the administered vaccine.
 * @property string $orderedby The username of the user who ordered the vaccine
 * @property string $ordereddate Date the vaccine was ordered
 * @property string $partiallyadministered Whether this vaccine was partially administered or not.
 * @property int $patientid ID of the patient that the vaccine is associated with.
 * @property string $prescribeddate Date when this vaccine was prescribed (if prescribed)
 * @property string $refuseddate Date when this vaccine was refused (if refused)
 * @property string $refusednote Note associated with refusal, if available
 * @property string $refusedreason Reason for refusal, if available
 * @property string $status Status of this vaccine (one of: ADMINISTERED, REFUSED, PRESCRIBED but not adminstered yet)
 * @property string $submitdate Date when this vaccine order was submitted, if clinical
 * @property string $units Units corresponding to the above quantity
 * @property string $vaccinator Individual who has administered the vaccine
 * @property string $vaccineid Athena ID for this vaccine (prefix of H for historical, C for clinical)
 * @property VaccineInformationStatements[] $vaccineinformationstatements The Vaccine Information Statements (VIS) that were given to the patient, grouped by Clinical Order Class
 * @property string $vaccinetype Type of vaccine (either CLINICAL - ordered/administered by the practice, or HISTORICAL - from patient's previous medical history or alternative source)
 * @property string $visgivendate Date when the Vaccine Information Statement was given to the patient
 * @property string $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Vaccine extends \yii\db\ActiveRecord
{
 
    protected $_clinicalorderclassesAr;
 
    protected $_contraindicationreasonAr;
 
    protected $_declinedreasonAr;
 
    protected $_vaccineinformationstatementsAr;

    public static function tableName()
    {
        return '{{%vaccines}}';
    }

    public function rules()
    {
        return [
            [['administerdate', 'administernote', 'administerroute', 'administerroutedescription', 'administersite', 'approvedby', 'approveddate', 'declinedreasontext', 'deleteddate', 'description', 'enteredby', 'entereddate', 'expirationdate', 'genusname', 'lotnumber', 'mvx', 'ndc', 'orderedby', 'ordereddate', 'partiallyadministered', 'prescribeddate', 'refuseddate', 'refusednote', 'refusedreason', 'status', 'submitdate', 'units', 'vaccinator', 'vaccineid', 'vaccinetype', 'visgivendate', 'externalId'], 'trim'],
            [['administerdate', 'administernote', 'administerroute', 'administerroutedescription', 'administersite', 'approvedby', 'approveddate', 'declinedreasontext', 'deleteddate', 'description', 'enteredby', 'entereddate', 'expirationdate', 'genusname', 'lotnumber', 'mvx', 'ndc', 'orderedby', 'ordereddate', 'partiallyadministered', 'prescribeddate', 'refuseddate', 'refusednote', 'refusedreason', 'status', 'submitdate', 'units', 'vaccinator', 'vaccineid', 'vaccinetype', 'visgivendate', 'externalId'], 'string'],
            [['chartsharinggroupid', 'cvx', 'patientid', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getClinicalorderclasses()
    {
        return $this->hasMany(ClinicalOrderClass::class, ['vaccine_id' => 'id']);
    }

    public function getContraindicationreason()
    {
        return $this->hasMany(ContraindicationReason::class, ['vaccine_id' => 'id']);
    }

    public function getDeclinedreason()
    {
        return $this->hasMany(DeclinedReason::class, ['vaccine_id' => 'id']);
    }

    public function getVaccineinformationstatements()
    {
        return $this->hasMany(VaccineInformationStatements::class, ['vaccine_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($administerdate = ArrayHelper::getValue($apiObject, 'administerdate')) {
            $this->administerdate = $administerdate;
        }
        if($administernote = ArrayHelper::getValue($apiObject, 'administernote')) {
            $this->administernote = $administernote;
        }
        if($administerroute = ArrayHelper::getValue($apiObject, 'administerroute')) {
            $this->administerroute = $administerroute;
        }
        if($administerroutedescription = ArrayHelper::getValue($apiObject, 'administerroutedescription')) {
            $this->administerroutedescription = $administerroutedescription;
        }
        if($administersite = ArrayHelper::getValue($apiObject, 'administersite')) {
            $this->administersite = $administersite;
        }
        if($amount = ArrayHelper::getValue($apiObject, 'amount')) {
            $this->amount = $amount;
        }
        if($approvedby = ArrayHelper::getValue($apiObject, 'approvedby')) {
            $this->approvedby = $approvedby;
        }
        if($approveddate = ArrayHelper::getValue($apiObject, 'approveddate')) {
            $this->approveddate = $approveddate;
        }
        if($chartsharinggroupid = ArrayHelper::getValue($apiObject, 'chartsharinggroupid')) {
            $this->chartsharinggroupid = $chartsharinggroupid;
        }
        if($clinicalorderclasses = ArrayHelper::getValue($apiObject, 'clinicalorderclasses')) {
            $this->_clinicalorderclassesAr = $clinicalorderclasses;
        }
        if($contraindicationreason = ArrayHelper::getValue($apiObject, 'contraindicationreason')) {
            $this->_contraindicationreasonAr = $contraindicationreason;
        }
        if($cvx = ArrayHelper::getValue($apiObject, 'cvx')) {
            $this->cvx = $cvx;
        }
        if($declinedreason = ArrayHelper::getValue($apiObject, 'declinedreason')) {
            $this->_declinedreasonAr = $declinedreason;
        }
        if($declinedreasontext = ArrayHelper::getValue($apiObject, 'declinedreasontext')) {
            $this->declinedreasontext = $declinedreasontext;
        }
        if($deleteddate = ArrayHelper::getValue($apiObject, 'deleteddate')) {
            $this->deleteddate = $deleteddate;
        }
        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($enteredby = ArrayHelper::getValue($apiObject, 'enteredby')) {
            $this->enteredby = $enteredby;
        }
        if($entereddate = ArrayHelper::getValue($apiObject, 'entereddate')) {
            $this->entereddate = $entereddate;
        }
        if($expirationdate = ArrayHelper::getValue($apiObject, 'expirationdate')) {
            $this->expirationdate = $expirationdate;
        }
        if($genusname = ArrayHelper::getValue($apiObject, 'genusname')) {
            $this->genusname = $genusname;
        }
        if($lotnumber = ArrayHelper::getValue($apiObject, 'lotnumber')) {
            $this->lotnumber = $lotnumber;
        }
        if($mvx = ArrayHelper::getValue($apiObject, 'mvx')) {
            $this->mvx = $mvx;
        }
        if($ndc = ArrayHelper::getValue($apiObject, 'ndc')) {
            $this->ndc = $ndc;
        }
        if($orderedby = ArrayHelper::getValue($apiObject, 'orderedby')) {
            $this->orderedby = $orderedby;
        }
        if($ordereddate = ArrayHelper::getValue($apiObject, 'ordereddate')) {
            $this->ordereddate = $ordereddate;
        }
        if($partiallyadministered = ArrayHelper::getValue($apiObject, 'partiallyadministered')) {
            $this->partiallyadministered = $partiallyadministered;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($prescribeddate = ArrayHelper::getValue($apiObject, 'prescribeddate')) {
            $this->prescribeddate = $prescribeddate;
        }
        if($refuseddate = ArrayHelper::getValue($apiObject, 'refuseddate')) {
            $this->refuseddate = $refuseddate;
        }
        if($refusednote = ArrayHelper::getValue($apiObject, 'refusednote')) {
            $this->refusednote = $refusednote;
        }
        if($refusedreason = ArrayHelper::getValue($apiObject, 'refusedreason')) {
            $this->refusedreason = $refusedreason;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($submitdate = ArrayHelper::getValue($apiObject, 'submitdate')) {
            $this->submitdate = $submitdate;
        }
        if($units = ArrayHelper::getValue($apiObject, 'units')) {
            $this->units = $units;
        }
        if($vaccinator = ArrayHelper::getValue($apiObject, 'vaccinator')) {
            $this->vaccinator = $vaccinator;
        }
        if($vaccineid = ArrayHelper::getValue($apiObject, 'vaccineid')) {
            $this->vaccineid = $vaccineid;
        }
        if($vaccineid = ArrayHelper::getValue($apiObject, 'vaccineid')) {
            $this->externalId = $vaccineid;
        }
        if($vaccineinformationstatements = ArrayHelper::getValue($apiObject, 'vaccineinformationstatements')) {
            $this->_vaccineinformationstatementsAr = $vaccineinformationstatements;
        }
        if($vaccinetype = ArrayHelper::getValue($apiObject, 'vaccinetype')) {
            $this->vaccinetype = $vaccinetype;
        }
        if($visgivendate = ArrayHelper::getValue($apiObject, 'visgivendate')) {
            $this->visgivendate = $visgivendate;
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
        if( !empty($this->_clinicalorderclassesAr) and is_array($this->_clinicalorderclassesAr) ) {
            foreach($this->_clinicalorderclassesAr as $clinicalorderclassesApi) {
                $clinicalorderclass = new ClinicalOrderClass();
                $clinicalorderclass->loadApiObject($clinicalorderclassesApi);
                $clinicalorderclass->link('vaccine', $this);
                $clinicalorderclass->save();
            }
        }
        if( !empty($this->_contraindicationreasonAr) and is_array($this->_contraindicationreasonAr) ) {
            foreach($this->_contraindicationreasonAr as $contraindicationreasonApi) {
                $contraindicationreason = new ContraindicationReason();
                $contraindicationreason->loadApiObject($contraindicationreasonApi);
                $contraindicationreason->link('vaccine', $this);
                $contraindicationreason->save();
            }
        }
        if( !empty($this->_declinedreasonAr) and is_array($this->_declinedreasonAr) ) {
            foreach($this->_declinedreasonAr as $declinedreasonApi) {
                $declinedreason = new DeclinedReason();
                $declinedreason->loadApiObject($declinedreasonApi);
                $declinedreason->link('vaccine', $this);
                $declinedreason->save();
            }
        }
        if( !empty($this->_vaccineinformationstatementsAr) and is_array($this->_vaccineinformationstatementsAr) ) {
            foreach($this->_vaccineinformationstatementsAr as $vaccineinformationstatementsApi) {
                $vaccineinformationstatements = new VaccineInformationStatements();
                $vaccineinformationstatements->loadApiObject($vaccineinformationstatementsApi);
                $vaccineinformationstatements->link('vaccine', $this);
                $vaccineinformationstatements->save();
            }
        }

        return $saved;
    }
    */
}
