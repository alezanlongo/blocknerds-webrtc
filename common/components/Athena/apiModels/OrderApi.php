<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $class The primary class of this order -- PRESCRIPTION, VACCINE, LAB, IMAGING, PATIENTINFO, etc.
 * @property string $classdescription The human-readable description of this document class, including sub class (prescription - new vs. prescription - renewal).
 * @property string $clinicalprovider The name of the facility, person, or group that the order is being sent to.
 * @property int $clinicalproviderid The ID of the facility (facilityid), person, or group that the order is being sent to.
 * @property string $clinicalproviderordertype The Name for the type of order referred to by a clinical provider (A clinical provider here refers to a facility).
 * @property int $clinicalproviderordertypeid The Unique ID for the type of order referred to by a clinical provider (A clinical provider here refers to a facility).
 * @property ContraindicationReason[] $contraindicationreason List of codes indicating why the order was contraindicated (for vaccines only). If this field is not present, the order does not contain a contraindication reason.
 * @property string $createduser The username of the person who created the order.
 * @property string $dateordered The timestamp when the order was created.
 * @property DeclinedReason[] $declinedreason List of codes indicating why the order was not given. If this field is not present, the order was not declined. If the array is empty, no reason has been chosen.
 * @property string $declinedreasontext The user-facing description of the reason the order was not given.
 * @property int $departmentid Department ID of the Provider
 * @property string $description A human readable description for this order
 * @property DiagnosisList[] $diagnosislist List of Diagnosis related to this order.
 * @property string $documentationonly If true, this order is here just as a record, and does not need to actually go out.
 * @property Document[] $documents The list of documents attached to this order. This can be letters, lab or imaging results, prescription renewals, etc.
 * @property ExternalCode[] $externalcodes When available, contains how this order maps to external vocabularies like LOINC, CVX, SNOMED, RXNORM, etc.
 * @property int $orderid The order (aka document) ID for this order.
 * @property string $orderingprovider The username of the ordering provider, which is different than the ordering user -- who may be an intake nurse for example.
 * @property string $ordertype The type of this order (Lab, Vaccine, etc.)
 * @property int $ordertypeid The athena ID for this type of order. Can be used to create another order of this type.
 * @property int $priority Priority of an order. 1 is high; 2 is normal.
 * @property int $providerid ID of the Provider
 * @property Question[] $questions BETA FIELD: The custom list of questions and answers associated with this order. This list will vary by practice.
 * @property string $specimencollectionsite The location where a clinical specimen if any was collected.
 * @property string $status The status the document is in (PEND, CLOSED, SUBMIT, SUBMITTED, etc).
 */
class OrderApi extends BaseApiModel
{

    public $class;
    public $classdescription;
    public $clinicalprovider;
    public $clinicalproviderid;
    public $clinicalproviderordertype;
    public $clinicalproviderordertypeid;
    public $contraindicationreason;
 
    protected $_contraindicationreasonAr;
    public $createduser;
    public $dateordered;
    public $declinedreason;
 
    protected $_declinedreasonAr;
    public $declinedreasontext;
    public $departmentid;
    public $description;
    public $diagnosislist;
 
    protected $_diagnosislistAr;
    public $documentationonly;
    public $documents;
 
    protected $_documentsAr;
    public $externalcodes;
 
    protected $_externalcodesAr;
    public $orderid;
    public $orderingprovider;
    public $ordertype;
    public $ordertypeid;
    public $priority;
    public $providerid;
    public $questions;
 
    protected $_questionsAr;
    public $specimencollectionsite;
    public $status;

    public function rules()
    {
        return [
            [['class', 'classdescription', 'clinicalprovider', 'clinicalproviderordertype', 'createduser', 'dateordered', 'declinedreasontext', 'description', 'documentationonly', 'orderingprovider', 'ordertype', 'specimencollectionsite', 'status'], 'trim'],
            [['class', 'classdescription', 'clinicalprovider', 'clinicalproviderordertype', 'createduser', 'dateordered', 'declinedreasontext', 'description', 'documentationonly', 'orderingprovider', 'ordertype', 'specimencollectionsite', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
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
        if (!empty($this->diagnosislist) && is_array($this->diagnosislist)) {
            foreach($this->diagnosislist as $diagnosislist) {
                $this->_diagnosislistAr[] = new DiagnosisListApi($diagnosislist);
            }
            $this->diagnosislist = $this->_diagnosislistAr;
            $this->_diagnosislistAr = [];//CHECKME
        }
        if (!empty($this->documents) && is_array($this->documents)) {
            foreach($this->documents as $documents) {
                $this->_documentsAr[] = new DocumentApi($documents);
            }
            $this->documents = $this->_documentsAr;
            $this->_documentsAr = [];//CHECKME
        }
        if (!empty($this->externalcodes) && is_array($this->externalcodes)) {
            foreach($this->externalcodes as $externalcodes) {
                $this->_externalcodesAr[] = new ExternalCodeApi($externalcodes);
            }
            $this->externalcodes = $this->_externalcodesAr;
            $this->_externalcodesAr = [];//CHECKME
        }
        if (!empty($this->questions) && is_array($this->questions)) {
            foreach($this->questions as $questions) {
                $this->_questionsAr[] = new QuestionApi($questions);
            }
            $this->questions = $this->_questionsAr;
            $this->_questionsAr = [];//CHECKME
        }
    }

}
