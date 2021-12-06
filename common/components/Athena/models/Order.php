<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Order extends \yii\db\ActiveRecord
{
 
    protected $_contraindicationreasonAr;
 
    protected $_declinedreasonAr;
 
    protected $_diagnosislistAr;
 
    protected $_documentsAr;
 
    protected $_externalcodesAr;
 
    protected $_questionsAr;

    public static function tableName()
    {
        return '{{%orders}}';
    }

    public function rules()
    {
        return [
            [['class', 'classdescription', 'clinicalprovider', 'clinicalproviderordertype', 'createduser', 'dateordered', 'declinedreasontext', 'description', 'documentationonly', 'orderingprovider', 'ordertype', 'specimencollectionsite', 'status'], 'trim'],
            [['class', 'classdescription', 'clinicalprovider', 'clinicalproviderordertype', 'createduser', 'dateordered', 'declinedreasontext', 'description', 'documentationonly', 'orderingprovider', 'ordertype', 'specimencollectionsite', 'status'], 'string'],
            [['clinicalproviderid', 'clinicalproviderordertypeid', 'departmentid', 'orderid', 'ordertypeid', 'priority', 'providerid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getContraindicationreason()
    {
        return $this->hasMany(ContraindicationReason::class, ['order_id' => 'id']);
    }

    public function getDeclinedreason()
    {
        return $this->hasMany(DeclinedReason::class, ['order_id' => 'id']);
    }

    public function getDiagnosislist()
    {
        return $this->hasMany(DiagnosisList::class, ['order_id' => 'id']);
    }

    public function getDocuments()
    {
        return $this->hasMany(Document::class, ['order_id' => 'id']);
    }

    public function getExternalcodes()
    {
        return $this->hasMany(ExternalCode::class, ['order_id' => 'id']);
    }

    public function getQuestions()
    {
        return $this->hasMany(Question::class, ['order_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($class = ArrayHelper::getValue($apiObject, 'class')) {
            $this->class = $class;
        }
        if($classdescription = ArrayHelper::getValue($apiObject, 'classdescription')) {
            $this->classdescription = $classdescription;
        }
        if($clinicalprovider = ArrayHelper::getValue($apiObject, 'clinicalprovider')) {
            $this->clinicalprovider = $clinicalprovider;
        }
        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($clinicalproviderordertype = ArrayHelper::getValue($apiObject, 'clinicalproviderordertype')) {
            $this->clinicalproviderordertype = $clinicalproviderordertype;
        }
        if($clinicalproviderordertypeid = ArrayHelper::getValue($apiObject, 'clinicalproviderordertypeid')) {
            $this->clinicalproviderordertypeid = $clinicalproviderordertypeid;
        }
        if($contraindicationreason = ArrayHelper::getValue($apiObject, 'contraindicationreason')) {
            $this->_contraindicationreasonAr = $contraindicationreason;
        }
        if($createduser = ArrayHelper::getValue($apiObject, 'createduser')) {
            $this->createduser = $createduser;
        }
        if($dateordered = ArrayHelper::getValue($apiObject, 'dateordered')) {
            $this->dateordered = $dateordered;
        }
        if($declinedreason = ArrayHelper::getValue($apiObject, 'declinedreason')) {
            $this->_declinedreasonAr = $declinedreason;
        }
        if($declinedreasontext = ArrayHelper::getValue($apiObject, 'declinedreasontext')) {
            $this->declinedreasontext = $declinedreasontext;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($diagnosislist = ArrayHelper::getValue($apiObject, 'diagnosislist')) {
            $this->_diagnosislistAr = $diagnosislist;
        }
        if($documentationonly = ArrayHelper::getValue($apiObject, 'documentationonly')) {
            $this->documentationonly = $documentationonly;
        }
        if($documents = ArrayHelper::getValue($apiObject, 'documents')) {
            $this->_documentsAr = $documents;
        }
        if($externalcodes = ArrayHelper::getValue($apiObject, 'externalcodes')) {
            $this->_externalcodesAr = $externalcodes;
        }
        if($orderid = ArrayHelper::getValue($apiObject, 'orderid')) {
            $this->orderid = $orderid;
        }
        if($orderid = ArrayHelper::getValue($apiObject, 'orderid')) {
            $this->externalId = $orderid;
        }
        if($orderingprovider = ArrayHelper::getValue($apiObject, 'orderingprovider')) {
            $this->orderingprovider = $orderingprovider;
        }
        if($ordertype = ArrayHelper::getValue($apiObject, 'ordertype')) {
            $this->ordertype = $ordertype;
        }
        if($ordertypeid = ArrayHelper::getValue($apiObject, 'ordertypeid')) {
            $this->ordertypeid = $ordertypeid;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($questions = ArrayHelper::getValue($apiObject, 'questions')) {
            $this->_questionsAr = $questions;
        }
        if($specimencollectionsite = ArrayHelper::getValue($apiObject, 'specimencollectionsite')) {
            $this->specimencollectionsite = $specimencollectionsite;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
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
        if( !empty($this->_contraindicationreasonAr) and is_array($this->_contraindicationreasonAr) ) {
            foreach($this->_contraindicationreasonAr as $contraindicationreasonApi) {
                $contraindicationreason = new ContraindicationReason();
                $contraindicationreason->loadApiObject($contraindicationreasonApi);
                $contraindicationreason->link('order', $this);
                $contraindicationreason->save();
            }
        }
        if( !empty($this->_declinedreasonAr) and is_array($this->_declinedreasonAr) ) {
            foreach($this->_declinedreasonAr as $declinedreasonApi) {
                $declinedreason = new DeclinedReason();
                $declinedreason->loadApiObject($declinedreasonApi);
                $declinedreason->link('order', $this);
                $declinedreason->save();
            }
        }
        if( !empty($this->_diagnosislistAr) and is_array($this->_diagnosislistAr) ) {
            foreach($this->_diagnosislistAr as $diagnosislistApi) {
                $diagnosislist = new DiagnosisList();
                $diagnosislist->loadApiObject($diagnosislistApi);
                $diagnosislist->link('order', $this);
                $diagnosislist->save();
            }
        }
        if( !empty($this->_documentsAr) and is_array($this->_documentsAr) ) {
            foreach($this->_documentsAr as $documentsApi) {
                $document = new Document();
                $document->loadApiObject($documentsApi);
                $document->link('order', $this);
                $document->save();
            }
        }
        if( !empty($this->_externalcodesAr) and is_array($this->_externalcodesAr) ) {
            foreach($this->_externalcodesAr as $externalcodesApi) {
                $externalcode = new ExternalCode();
                $externalcode->loadApiObject($externalcodesApi);
                $externalcode->link('order', $this);
                $externalcode->save();
            }
        }
        if( !empty($this->_questionsAr) and is_array($this->_questionsAr) ) {
            foreach($this->_questionsAr as $questionsApi) {
                $question = new Question();
                $question->loadApiObject($questionsApi);
                $question->link('order', $this);
                $question->save();
            }
        }

        return $saved;
    }
    */
}
