<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $patientid The athenaNet patient ID.
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
 */
class ClinicalDocumentApi extends BaseApiModel
{

    public $patientid;
    public $actionnote;
    public $assignedto;
    public $clinicaldocumentid;
    public $clinicalproviderid;
    public $createddate;
    public $createddatetime;
    public $createduser;
    public $departmentid;
    public $documentclass;
    public $documentdata;
    public $documentdescription;
    public $documentroute;
    public $documentsource;
    public $documentsubclass;
    public $documenttypeid;
    public $externalnote;
    public $internalnote;
    public $lastmodifieddate;
    public $lastmodifieddatetime;
    public $lastmodifieduser;
    public $observationdate;
    public $ordertype;
    public $pages;
 
    protected $_pagesAr;
    public $priority;
    public $providerid;
    public $providerusername;
    public $status;
    public $tietoorderid;

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'departmentid', 'documentclass', 'documentdata', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'externalnote', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdate', 'ordertype', 'priority', 'providerusername', 'status'], 'trim'],
            [['actionnote', 'assignedto', 'createddate', 'createddatetime', 'createduser', 'departmentid', 'documentclass', 'documentdata', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'externalnote', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdate', 'ordertype', 'priority', 'providerusername', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->pages) && is_array($this->pages)) {
            foreach($this->pages as $pages) {
                $this->_pagesAr[] = new ClinicalDocumentPageDetailApi($pages);
            }
            $this->pages = $this->_pagesAr;
            $this->_pagesAr = [];//CHECKME
        }
    }

}
