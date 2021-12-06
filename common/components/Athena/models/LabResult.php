<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The most recent action note for a document
 * @property string $alarmdays The number days, weeks, months, or year until a lab result document will go into followup after being sent to the portal.
 * @property int $appointmentid The appointment ID for this document
 * @property string $assignedto Person the document is assigned to
 * @property string $createddate Date the document was created. Please use createddatetime instead.
 * @property string $createddatetime Date/Time (ISO 8601) the document was created
 * @property string $createduser The user who created this document.
 * @property string $deleteddatetime Date/time (ISO 8601) the document was deleted
 * @property string $departmentid Department for the document
 * @property string $description Description of the document type
 * @property string $documentclass Class of document
 * @property string $documentroute Explains method by which the document was entered into the AthenaNet (INTERFACE (digital), FAX, etc.)
 * @property string $documentsource Explains where this document originated.
 * @property string $documentsubclass Specific type of document
 * @property int $documenttypeid The ID of the description for this document
 * @property string $encounterdate Date of the encounter associated with this document
 * @property string $encounterid Encounter ID
 * @property string $externalaccessionid The external accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $externalnoteonly External note for the patient.
 * @property int $facilityid The ID of the clinical provider associated with this clinical document. Clinical providers are a master list of providers throughout the country.  These include providers as well as radiology centers, labs and pharmacies.
 * @property string $internalaccessionid The internal accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $internalnote The 'Internal Note' attached to this document
 * @property string $interpretation The practice entered interpretation of this result.
 * @property object $interpretationtemplate The interpretation template added to the imaging result.
 * @property string $isconfidential If true, this result document should not be shown to the patient.
 * @property int $labresultid The primary key for labresult class of documents
 * @property string $labresultloinc Laboratory code that identifies the overall result.
 * @property string $lastmodifieddate Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieddatetime Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieduser The user who last modified this document.
 * @property string $notefromlab A note from lab.
 * @property string $observationdate Date/time the observation was taken
 * @property string $observationdatetime Date/time (ISO 8601) the observation was taken
 * @property ObservationLabResult[] $observations Individual observation details
 * @property string $ordertype Order type group name
 * @property ClinicalDocumentPageDetail[] $pages An array of image pages associated with this document.
 * @property string $patientnote A note about this lab result for the patient.  This may or may not have been sent to the patient.
 * @property string $performinglabaddress1 This is the address1 field of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $performinglabaddress2 This is the address2 field of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $performinglabcity This is the city of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $performinglabname This is the name of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $performinglabstate This is the state of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $performinglabzip This is the zip code of the performing lab. For point-of-care tests this is the department. Otherwise, it is the clinical provider
 * @property string $portalpublisheddatetime The date the document was published to the portal in format (yyyy-mm-ddThh:mm:ss).
 * @property string $priority Document priority, when available. 1 is high, 2 is normal. Some labs use other numbers or characters that are lab-specific.
 * @property int $providerid Provider ID for this document
 * @property string $providerusername The username of the provider associated with this lab result document.
 * @property object $receivedfacilityordercode The code as received from the facility via HL7 in OBR.4.
 * @property string $reportstatus The status of the report.
 * @property string $resultcategory The category of the result.
 * @property string $resultnotes Result note on a document.
 * @property string $resultstatus The status of the result.
 * @property string $status Status of the document
 * @property string $subject Subject of the document
 * @property int $tietoorderid Order ID of the order this document is tied to, if any
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResult extends \yii\db\ActiveRecord
{
 
    protected $_observationsAr;
 
    protected $_pagesAr;

    public static function tableName()
    {
        return '{{%lab_results}}';
    }

    public function rules()
    {
        return [
            [['actionnote', 'alarmdays', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentroute', 'documentsource', 'documentsubclass', 'encounterdate', 'encounterid', 'externalaccessionid', 'externalnoteonly', 'internalaccessionid', 'internalnote', 'interpretation', 'isconfidential', 'labresultloinc', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'notefromlab', 'observationdate', 'observationdatetime', 'ordertype', 'patientnote', 'performinglabaddress1', 'performinglabaddress2', 'performinglabcity', 'performinglabname', 'performinglabstate', 'performinglabzip', 'portalpublisheddatetime', 'priority', 'providerusername', 'reportstatus', 'resultcategory', 'resultnotes', 'resultstatus', 'status', 'subject'], 'trim'],
            [['actionnote', 'alarmdays', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentroute', 'documentsource', 'documentsubclass', 'encounterdate', 'encounterid', 'externalaccessionid', 'externalnoteonly', 'internalaccessionid', 'internalnote', 'interpretation', 'isconfidential', 'labresultloinc', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'notefromlab', 'observationdate', 'observationdatetime', 'ordertype', 'patientnote', 'performinglabaddress1', 'performinglabaddress2', 'performinglabcity', 'performinglabname', 'performinglabstate', 'performinglabzip', 'portalpublisheddatetime', 'priority', 'providerusername', 'reportstatus', 'resultcategory', 'resultnotes', 'resultstatus', 'status', 'subject'], 'string'],
            [['appointmentid', 'documenttypeid', 'facilityid', 'labresultid', 'providerid', 'tietoorderid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getObservations()
    {
        return $this->hasMany(ObservationLabResult::class, ['lab_result_id' => 'id']);
    }

    public function getPages()
    {
        return $this->hasMany(ClinicalDocumentPageDetail::class, ['lab_result_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
        }
        if($alarmdays = ArrayHelper::getValue($apiObject, 'alarmdays')) {
            $this->alarmdays = $alarmdays;
        }
        if($appointmentid = ArrayHelper::getValue($apiObject, 'appointmentid')) {
            $this->appointmentid = $appointmentid;
        }
        if($assignedto = ArrayHelper::getValue($apiObject, 'assignedto')) {
            $this->assignedto = $assignedto;
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
        if($encounterdate = ArrayHelper::getValue($apiObject, 'encounterdate')) {
            $this->encounterdate = $encounterdate;
        }
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->encounterid = $encounterid;
        }
        if($externalaccessionid = ArrayHelper::getValue($apiObject, 'externalaccessionid')) {
            $this->externalaccessionid = $externalaccessionid;
        }
        if($externalnoteonly = ArrayHelper::getValue($apiObject, 'externalnoteonly')) {
            $this->externalnoteonly = $externalnoteonly;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
        }
        if($internalaccessionid = ArrayHelper::getValue($apiObject, 'internalaccessionid')) {
            $this->internalaccessionid = $internalaccessionid;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($interpretation = ArrayHelper::getValue($apiObject, 'interpretation')) {
            $this->interpretation = $interpretation;
        }
        if($interpretationtemplate = ArrayHelper::getValue($apiObject, 'interpretationtemplate')) {
            $this->interpretationtemplate = $interpretationtemplate;
        }
        if($isconfidential = ArrayHelper::getValue($apiObject, 'isconfidential')) {
            $this->isconfidential = $isconfidential;
        }
        if($labresultid = ArrayHelper::getValue($apiObject, 'labresultid')) {
            $this->labresultid = $labresultid;
        }
        if($labresultid = ArrayHelper::getValue($apiObject, 'labresultid')) {
            $this->externalId = $labresultid;
        }
        if($labresultloinc = ArrayHelper::getValue($apiObject, 'labresultloinc')) {
            $this->labresultloinc = $labresultloinc;
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
        if($notefromlab = ArrayHelper::getValue($apiObject, 'notefromlab')) {
            $this->notefromlab = $notefromlab;
        }
        if($observationdate = ArrayHelper::getValue($apiObject, 'observationdate')) {
            $this->observationdate = $observationdate;
        }
        if($observationdatetime = ArrayHelper::getValue($apiObject, 'observationdatetime')) {
            $this->observationdatetime = $observationdatetime;
        }
        if($observations = ArrayHelper::getValue($apiObject, 'observations')) {
            $this->_observationsAr = $observations;
        }
        if($ordertype = ArrayHelper::getValue($apiObject, 'ordertype')) {
            $this->ordertype = $ordertype;
        }
        if($pages = ArrayHelper::getValue($apiObject, 'pages')) {
            $this->_pagesAr = $pages;
        }
        if($patientnote = ArrayHelper::getValue($apiObject, 'patientnote')) {
            $this->patientnote = $patientnote;
        }
        if($performinglabaddress1 = ArrayHelper::getValue($apiObject, 'performinglabaddress1')) {
            $this->performinglabaddress1 = $performinglabaddress1;
        }
        if($performinglabaddress2 = ArrayHelper::getValue($apiObject, 'performinglabaddress2')) {
            $this->performinglabaddress2 = $performinglabaddress2;
        }
        if($performinglabcity = ArrayHelper::getValue($apiObject, 'performinglabcity')) {
            $this->performinglabcity = $performinglabcity;
        }
        if($performinglabname = ArrayHelper::getValue($apiObject, 'performinglabname')) {
            $this->performinglabname = $performinglabname;
        }
        if($performinglabstate = ArrayHelper::getValue($apiObject, 'performinglabstate')) {
            $this->performinglabstate = $performinglabstate;
        }
        if($performinglabzip = ArrayHelper::getValue($apiObject, 'performinglabzip')) {
            $this->performinglabzip = $performinglabzip;
        }
        if($portalpublisheddatetime = ArrayHelper::getValue($apiObject, 'portalpublisheddatetime')) {
            $this->portalpublisheddatetime = $portalpublisheddatetime;
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
        if($receivedfacilityordercode = ArrayHelper::getValue($apiObject, 'receivedfacilityordercode')) {
            $this->receivedfacilityordercode = $receivedfacilityordercode;
        }
        if($reportstatus = ArrayHelper::getValue($apiObject, 'reportstatus')) {
            $this->reportstatus = $reportstatus;
        }
        if($resultcategory = ArrayHelper::getValue($apiObject, 'resultcategory')) {
            $this->resultcategory = $resultcategory;
        }
        if($resultnotes = ArrayHelper::getValue($apiObject, 'resultnotes')) {
            $this->resultnotes = $resultnotes;
        }
        if($resultstatus = ArrayHelper::getValue($apiObject, 'resultstatus')) {
            $this->resultstatus = $resultstatus;
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
        if( !empty($this->_observationsAr) and is_array($this->_observationsAr) ) {
            foreach($this->_observationsAr as $observationsApi) {
                $observationlabresult = new ObservationLabResult();
                $observationlabresult->loadApiObject($observationsApi);
                $observationlabresult->link('labResult', $this);
                $observationlabresult->save();
            }
        }
        if( !empty($this->_pagesAr) and is_array($this->_pagesAr) ) {
            foreach($this->_pagesAr as $pagesApi) {
                $clinicaldocumentpagedetail = new ClinicalDocumentPageDetail();
                $clinicaldocumentpagedetail->loadApiObject($pagesApi);
                $clinicaldocumentpagedetail->link('labResult', $this);
                $clinicaldocumentpagedetail->save();
            }
        }

        return $saved;
    }
    */
}
