<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The most recent action note for a document
 * @property int $adminid The primary key for administrative class of documents
 * @property int $appointmentid The appointment ID for this document
 * @property string $assignedto Person the document is assigned to
 * @property int $clinicalproviderid The ID of the clinical provider associated with this clinical document. Clinical providers are a master list of providers throughout the country.  These include providers as well as radiology centers, labs and pharmacies.
 * @property string $createddate Date the document was created. Please use createddatetime instead.
 * @property string $createddatetime Date/Time (ISO 8601) the document was created
 * @property string $createduser The user who created this document.
 * @property string $deleteddatetime Date/time (ISO 8601) the document was deleted
 * @property string $departmentid Department for the document
 * @property string $description Description of the document type
 * @property string $documentclass Class of document
 * @property string $documentdata Text data associated with this document.
 * @property string $documentdate Date/time the observation was taken
 * @property string $documentroute Explains method by which the document was entered into the AthenaNet (INTERFACE (digital), FAX, etc.)
 * @property string $documentsource Explains where this document originated.
 * @property string $documentsubclass Specific type of document
 * @property int $documenttypeid A specific document type identifier.
 * @property string $encounterid Encounter ID
 * @property string $entitytype Type of entity creating the document. Possible values are PROVIDER, PATIENT and OTHERS.
 * @property string $externalaccessionid The external accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $externalnote External note for the patient.
 * @property string $internalaccessionid The internal accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $internalnote The 'Internal Note' attached to this document
 * @property string $lastmodifieddate Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieddatetime Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieduser The user who last modified this document.
 * @property object $originaldocument URL and content-type to download the original document
 * @property AdminDocumentPageDetail[] $pages An array of image pages associated with this document.
 * @property string $priority Document priority, when available. 1 is high, 2 is normal. Some labs use other numbers or characters that are lab-specific.
 * @property int $providerid Provider ID for this document
 * @property string $providerusername The username of the provider associated with this lab result document.
 * @property int $patientid A patient identifier.
 * @property string $status Status of the document
 * @property string $subject Subject of the document
 * @property int $tietoorderid Order ID of the order this document is tied to, if any
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AdminDocument extends \yii\db\ActiveRecord
{
 
    protected $_pagesAr;

    public static function tableName()
    {
        return '{{%admin_documents}}';
    }

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdata', 'documentdate', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'entitytype', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'priority', 'providerusername', 'status', 'subject'], 'trim'],
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdata', 'documentdate', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'entitytype', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'priority', 'providerusername', 'status', 'subject'], 'string'],
            [['adminid', 'appointmentid', 'clinicalproviderid', 'documenttypeid', 'providerid', 'patientid', 'tietoorderid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPages()
    {
        return $this->hasMany(AdminDocumentPageDetail::class, ['admin_document_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
        }
        if($adminid = ArrayHelper::getValue($apiObject, 'adminid')) {
            $this->adminid = $adminid;
        }
        if($adminid = ArrayHelper::getValue($apiObject, 'adminid')) {
            $this->externalId = $adminid;
        }
        if($appointmentid = ArrayHelper::getValue($apiObject, 'appointmentid')) {
            $this->appointmentid = $appointmentid;
        }
        if($assignedto = ArrayHelper::getValue($apiObject, 'assignedto')) {
            $this->assignedto = $assignedto;
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
        if($deleteddatetime = ArrayHelper::getValue($apiObject, 'deleteddatetime')) {
            $this->deleteddatetime = $deleteddatetime;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($documentclass = ArrayHelper::getValue($apiObject, 'documentclass')) {
            $this->documentclass = $documentclass;
        }
        if($documentdata = ArrayHelper::getValue($apiObject, 'documentdata')) {
            $this->documentdata = $documentdata;
        }
        if($documentdate = ArrayHelper::getValue($apiObject, 'documentdate')) {
            $this->documentdate = $documentdate;
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
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->encounterid = $encounterid;
        }
        if($entitytype = ArrayHelper::getValue($apiObject, 'entitytype')) {
            $this->entitytype = $entitytype;
        }
        if($externalaccessionid = ArrayHelper::getValue($apiObject, 'externalaccessionid')) {
            $this->externalaccessionid = $externalaccessionid;
        }
        if($externalnote = ArrayHelper::getValue($apiObject, 'externalnote')) {
            $this->externalnote = $externalnote;
        }
        if($internalaccessionid = ArrayHelper::getValue($apiObject, 'internalaccessionid')) {
            $this->internalaccessionid = $internalaccessionid;
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
        if($originaldocument = ArrayHelper::getValue($apiObject, 'originaldocument')) {
            $this->originaldocument = $originaldocument;
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
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($subject = ArrayHelper::getValue($apiObject, 'subject')) {
            $this->subject = $subject;
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
                $admindocumentpagedetail = new AdminDocumentPageDetail();
                $admindocumentpagedetail->loadApiObject($pagesApi);
                $admindocumentpagedetail->link('adminDocument', $this);
                $admindocumentpagedetail->save();
            }
        }

        return $saved;
    }
    */
}
