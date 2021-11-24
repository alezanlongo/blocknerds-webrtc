<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class VaccineApi extends BaseApiModel
{

    public $administerdate;
    public $administernote;
    public $administerroute;
    public $administerroutedescription;
    public $administersite;
    public $amount;
    public $approvedby;
    public $approveddate;
    public $chartsharinggroupid;
    public $clinicalorderclasses;
 
    protected $_clinicalorderclassesAr;
    public $contraindicationreason;
 
    protected $_contraindicationreasonAr;
    public $cvx;
    public $declinedreason;
 
    protected $_declinedreasonAr;
    public $declinedreasontext;
    public $deleteddate;
    public $description;
    public $enteredby;
    public $entereddate;
    public $expirationdate;
    public $genusname;
    public $lotnumber;
    public $mvx;
    public $ndc;
    public $orderedby;
    public $ordereddate;
    public $partiallyadministered;
    public $patientid;
    public $prescribeddate;
    public $refuseddate;
    public $refusednote;
    public $refusedreason;
    public $status;
    public $submitdate;
    public $units;
    public $vaccinator;
    public $vaccineid;
    public $vaccineinformationstatements;
 
    protected $_vaccineinformationstatementsAr;
    public $vaccinetype;
    public $visgivendate;

    public function rules()
    {
        return [
            [['administerdate', 'administernote', 'administerroute', 'administerroutedescription', 'administersite', 'approvedby', 'approveddate', 'declinedreasontext', 'deleteddate', 'description', 'enteredby', 'entereddate', 'expirationdate', 'genusname', 'lotnumber', 'mvx', 'ndc', 'orderedby', 'ordereddate', 'partiallyadministered', 'prescribeddate', 'refuseddate', 'refusednote', 'refusedreason', 'status', 'submitdate', 'units', 'vaccinator', 'vaccineid', 'vaccinetype', 'visgivendate'], 'trim'],
            [['administerdate', 'administernote', 'administerroute', 'administerroutedescription', 'administersite', 'approvedby', 'approveddate', 'declinedreasontext', 'deleteddate', 'description', 'enteredby', 'entereddate', 'expirationdate', 'genusname', 'lotnumber', 'mvx', 'ndc', 'orderedby', 'ordereddate', 'partiallyadministered', 'prescribeddate', 'refuseddate', 'refusednote', 'refusedreason', 'status', 'submitdate', 'units', 'vaccinator', 'vaccineid', 'vaccinetype', 'visgivendate'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->clinicalorderclasses) && is_array($this->clinicalorderclasses)) {
            foreach($this->clinicalorderclasses as $clinicalorderclasses) {
                $this->_clinicalorderclassesAr[] = new ClinicalOrderClassApi($clinicalorderclasses);
            }
            $this->clinicalorderclasses = $this->_clinicalorderclassesAr;
            $this->_clinicalorderclassesAr = [];//CHECKME
        }
        if (!empty($this->contraindicationreason) && is_array($this->contraindicationreason)) {
            foreach($this->contraindicationreason as $contraindicationreason) {
                $this->_contraindicationreasonAr[] = new ContraindicationReasonApi($contraindicationreason);
            }
            $this->contraindicationreason = $this->_contraindicationreasonAr;
            $this->_contraindicationreasonAr = [];//CHECKME
        }
        if (!empty($this->declinedreason) && is_array($this->declinedreason)) {
            foreach($this->declinedreason as $declinedreason) {
                $this->_declinedreasonAr[] = new DeclinedReasonApi($declinedreason);
            }
            $this->declinedreason = $this->_declinedreasonAr;
            $this->_declinedreasonAr = [];//CHECKME
        }
        if (!empty($this->vaccineinformationstatements) && is_array($this->vaccineinformationstatements)) {
            foreach($this->vaccineinformationstatements as $vaccineinformationstatements) {
                $this->_vaccineinformationstatementsAr[] = new VaccineInformationStatementsApi($vaccineinformationstatements);
            }
            $this->vaccineinformationstatements = $this->_vaccineinformationstatementsAr;
            $this->_vaccineinformationstatementsAr = [];//CHECKME
        }
    }

}
