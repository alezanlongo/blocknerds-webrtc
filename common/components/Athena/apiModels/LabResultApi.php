<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class LabResultApi extends BaseApiModel
{

    public $actionnote;
    public $alarmdays;
    public $appointmentid;
    public $assignedto;
    public $createddate;
    public $createddatetime;
    public $createduser;
    public $deleteddatetime;
    public $departmentid;
    public $description;
    public $documentclass;
    public $documentroute;
    public $documentsource;
    public $documentsubclass;
    public $documenttypeid;
    public $encounterdate;
    public $encounterid;
    public $externalaccessionid;
    public $externalnoteonly;
    public $facilityid;
    public $internalaccessionid;
    public $internalnote;
    public $interpretation;
    public $interpretationtemplate;
    public $isconfidential;
    public $labresultid;
    public $labresultloinc;
    public $lastmodifieddate;
    public $lastmodifieddatetime;
    public $lastmodifieduser;
    public $notefromlab;
    public $observationdate;
    public $observationdatetime;
    public $observations;
 
    protected $_observationsAr;
    public $ordertype;
    public $pages;
 
    protected $_pagesAr;
    public $patientnote;
    public $performinglabaddress1;
    public $performinglabaddress2;
    public $performinglabcity;
    public $performinglabname;
    public $performinglabstate;
    public $performinglabzip;
    public $portalpublisheddatetime;
    public $priority;
    public $providerid;
    public $providerusername;
    public $receivedfacilityordercode;
    public $reportstatus;
    public $resultcategory;
    public $resultnotes;
    public $resultstatus;
    public $status;
    public $subject;
    public $tietoorderid;

    public function rules()
    {
        return [
            [['actionnote', 'alarmdays', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentroute', 'documentsource', 'documentsubclass', 'encounterdate', 'encounterid', 'externalaccessionid', 'externalnoteonly', 'internalaccessionid', 'internalnote', 'interpretation', 'isconfidential', 'labresultloinc', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'notefromlab', 'observationdate', 'observationdatetime', 'ordertype', 'patientnote', 'performinglabaddress1', 'performinglabaddress2', 'performinglabcity', 'performinglabname', 'performinglabstate', 'performinglabzip', 'portalpublisheddatetime', 'priority', 'providerusername', 'reportstatus', 'resultcategory', 'resultnotes', 'resultstatus', 'status', 'subject'], 'trim'],
            [['actionnote', 'alarmdays', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentroute', 'documentsource', 'documentsubclass', 'encounterdate', 'encounterid', 'externalaccessionid', 'externalnoteonly', 'internalaccessionid', 'internalnote', 'interpretation', 'isconfidential', 'labresultloinc', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'notefromlab', 'observationdate', 'observationdatetime', 'ordertype', 'patientnote', 'performinglabaddress1', 'performinglabaddress2', 'performinglabcity', 'performinglabname', 'performinglabstate', 'performinglabzip', 'portalpublisheddatetime', 'priority', 'providerusername', 'reportstatus', 'resultcategory', 'resultnotes', 'resultstatus', 'status', 'subject'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->observations) && is_array($this->observations)) {
            foreach($this->observations as $observations) {
                $this->_observationsAr[] = new ObservationLabResultApi($observations);
            }
            $this->observations = $this->_observationsAr;
            $this->_observationsAr = [];//CHECKME
        }
        if (!empty($this->pages) && is_array($this->pages)) {
            foreach($this->pages as $pages) {
                $this->_pagesAr[] = new ClinicalDocumentPageDetailApi($pages);
            }
            $this->pages = $this->_pagesAr;
            $this->_pagesAr = [];//CHECKME
        }
    }

}
