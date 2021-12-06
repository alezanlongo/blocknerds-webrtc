<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class AdminDocumentApi extends BaseApiModel
{

    public $actionnote;
    public $adminid;
    public $appointmentid;
    public $assignedto;
    public $clinicalproviderid;
    public $createddate;
    public $createddatetime;
    public $createduser;
    public $deleteddatetime;
    public $departmentid;
    public $description;
    public $documentclass;
    public $documentdata;
    public $documentdate;
    public $documentroute;
    public $documentsource;
    public $documentsubclass;
    public $documenttypeid;
    public $encounterid;
    public $entitytype;
    public $externalaccessionid;
    public $externalnote;
    public $internalaccessionid;
    public $internalnote;
    public $lastmodifieddate;
    public $lastmodifieddatetime;
    public $lastmodifieduser;
    public $originaldocument;
    public $pages;
 
    protected $_pagesAr;
    public $priority;
    public $providerid;
    public $providerusername;
    public $patientid;
    public $status;
    public $subject;
    public $tietoorderid;

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdata', 'documentdate', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'entitytype', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'priority', 'providerusername', 'status', 'subject'], 'trim'],
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdata', 'documentdate', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'entitytype', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'priority', 'providerusername', 'status', 'subject'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->pages) && is_array($this->pages)) {
            foreach($this->pages as $pages) {
                $this->_pagesAr[] = new AdminDocumentPageDetailApi($pages);
            }
            $this->pages = $this->_pagesAr;
            $this->_pagesAr = [];//CHECKME
        }
    }

}
