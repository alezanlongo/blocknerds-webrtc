<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The most recent action note for a document
 * @property string $assignedto Person the document is assigned to
 * @property int $clinicaldocumentid The primary key for the clinical document.
 * @property int $clinicalproviderid The ID of the clinical provider associated with this clinical document. Clinical providers are a master list of providers throughout the country.  These include providers as well as radiology centers, labs and pharmacies.
 * @property string $createddate Date the document was created. Please use createddatetime instead.
 * @property string $createddatetime Date/Time (ISO 8601) the document was created
 * @property string $createduser The user who created this document.
 * @property string $departmentid Department for the document
 * @property string $documentclass Class of document
 * @property string $documentdata Text data associated with this document.
 * @property string $documentdescription Description of the document type
 * @property string $documentroute Explains method by which the document was entered into the AthenaNet (INTERFACE (digital), FAX, etc.)
 * @property string $documentsource Explains where this document originated.
 * @property string $documentsubclass Specific type of document
 * @property int $documenttypeid The ID of the description for this document
 * @property string $externalnote External note for the patient.
 * @property string $internalnote The 'Internal Note' attached to this document
 * @property string $lastmodifieddate
 * @property string $lastmodifieddatetime Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieduser The user who last modified this document.
 * @property string $observationdate Date of the encounter associated with this document
 * @property string $ordertype Order type group name
 * @property ClinicalDocumentPageDetail[] $pages An array of image pages associated with this document.
 * @property string $priority Document priority, when available. 1 is high, 2 is normal. Some labs use other numbers or characters that are lab-specific.
 * @property int $providerid Provider ID for this document
 * @property string $providerusername The username of the provider associated with this lab result document.
 * @property string $status Status of the document
 * @property int $tietoorderid Order ID of the order this document is tied to, if any
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ClinicalDocument extends \yii\db\ActiveRecord
{
 
    protected $_pagesAr;

    public static function tableName()
    {
        return '{{%clinical_documents}}';
    }

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'departmentid', 'documentclass', 'documentdata', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'externalnote', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdate', 'ordertype', 'priority', 'providerusername', 'status'], 'trim'],
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'departmentid', 'documentclass', 'documentdata', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'externalnote', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdate', 'ordertype', 'priority', 'providerusername', 'status'], 'string'],
            [['clinicaldocumentid', 'clinicalproviderid', 'documenttypeid', 'providerid', 'tietoorderid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPages()
    {
        return $this->hasMany(ClinicalDocumentPageDetail::class, ['clinical_document_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
        }
        if($assignedto = ArrayHelper::getValue($apiObject, 'assignedto')) {
            $this->assignedto = $assignedto;
        }
        if($clinicaldocumentid = ArrayHelper::getValue($apiObject, 'clinicaldocumentid')) {
            $this->clinicaldocumentid = $clinicaldocumentid;
        }
        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($createddate = ArrayHelper::getValue($apiObject, 'createddate')) {
            $this->createddate = $createddate;
        }
        if($createddatetime = ArrayHelper::getValue($apiObject, 'createddatetime')) {
            $this->createddatetime = $createddatetime;
        }
        if($createduser = ArrayHelper::getValue($apiObject, 'createduser')) {
            $this->createduser = $createduser;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($documentclass = ArrayHelper::getValue($apiObject, 'documentclass')) {
            $this->documentclass = $documentclass;
        }
        if($documentdata = ArrayHelper::getValue($apiObject, 'documentdata')) {
            $this->documentdata = $documentdata;
        }
        if($documentdescription = ArrayHelper::getValue($apiObject, 'documentdescription')) {
            $this->documentdescription = $documentdescription;
        }
        if($documentroute = ArrayHelper::getValue($apiObject, 'documentroute')) {
            $this->documentroute = $documentroute;
        }
        if($documentsource = ArrayHelper::getValue($apiObject, 'documentsource')) {
            $this->documentsource = $documentsource;
        }
        if($documentsubclass = ArrayHelper::getValue($apiObject, 'documentsubclass')) {
            $this->documentsubclass = $documentsubclass;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($externalnote = ArrayHelper::getValue($apiObject, 'externalnote')) {
            $this->externalnote = $externalnote;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($lastmodifieddate = ArrayHelper::getValue($apiObject, 'lastmodifieddate')) {
            $this->lastmodifieddate = $lastmodifieddate;
        }
        if($lastmodifieddatetime = ArrayHelper::getValue($apiObject, 'lastmodifieddatetime')) {
            $this->lastmodifieddatetime = $lastmodifieddatetime;
        }
        if($lastmodifieduser = ArrayHelper::getValue($apiObject, 'lastmodifieduser')) {
            $this->lastmodifieduser = $lastmodifieduser;
        }
        if($observationdate = ArrayHelper::getValue($apiObject, 'observationdate')) {
            $this->observationdate = $observationdate;
        }
        if($ordertype = ArrayHelper::getValue($apiObject, 'ordertype')) {
            $this->ordertype = $ordertype;
        }
        if($pages = ArrayHelper::getValue($apiObject, 'pages')) {
            $this->_pagesAr = $pages;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($providerusername = ArrayHelper::getValue($apiObject, 'providerusername')) {
            $this->providerusername = $providerusername;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($tietoorderid = ArrayHelper::getValue($apiObject, 'tietoorderid')) {
            $this->tietoorderid = $tietoorderid;
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
        if( !empty($this->_pagesAr) and is_array($this->_pagesAr) ) {
            foreach($this->_pagesAr as $pagesApi) {
                $clinicaldocumentpagedetail = new ClinicalDocumentPageDetail();
                $clinicaldocumentpagedetail->loadApiObject($pagesApi);
                $clinicaldocumentpagedetail->link('clinicalDocument', $this);
                $clinicaldocumentpagedetail->save();
            }
        }

        return $saved;
    }
    */
}
