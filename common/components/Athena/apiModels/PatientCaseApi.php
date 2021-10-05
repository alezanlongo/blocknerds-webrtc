<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $actionnote The most recent action note for a document
 * @property string $assignedto Person the document is assigned to
 * @property string $callbackname The person to call (if other than patient).
 * @property string $callbacknumber The phone number to use to call back the patient.
 * @property string $callbacknumbertype The type of callback number (e.g. home, office, work, guarantor).
 * @property string $calltype Type of call.  (Options include: Tickler, Cancellation, ReminderCall etc...)
 * @property int $clinicalproviderid DEPRECATED:  The clinical provider ID.  The information can now be found in the field entitled 'facilityid'
 * @property string $createddate Date the document was created. Please use createddatetime instead.
 * @property string $createddatetime Date/Time (ISO 8601) the document was created
 * @property array $createddocuments Documents created by a patient case.
 * @property string $createduser The user who created this document.
 * @property string $deleteddatetime Date/time (ISO 8601) the document was deleted
 * @property string $departmentid Department for the document
 * @property string $description Description of the document type
 * @property string $documentclass Class of document
 * @property string $documentdescription DEPRECATED:  The document description.  The information can now be found in the field entitled 'description'
 * @property string $documentroute Explains method by which the document was entered into the AthenaNet (INTERFACE (digital), FAX, etc.)
 * @property string $documentsource Explains where this document originated.
 * @property string $documentsubclass Specific type of document
 * @property int $documenttypeid A specific document type identifier.
 * @property string $encounterid Encounter ID
 * @property string $externalaccessionid The external accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $externalnote External note for the patient.
 * @property int $facilityid The ID of the clinical provider associated with this clinical document. Clinical providers are a master list of providers throughout the country.  These include providers as well as radiology centers, labs and pharmacies.
 * @property string $internalaccessionid The internal accession ID for this document. Format depends on the system the ID belongs to.
 * @property string $internalnote The 'Internal Note' attached to this document
 * @property string $lastmodifieddate DEPRECATED:  The last modified date.  The information can now be found in the field entitled lastmodifieddatetime
 * @property string $lastmodifieddatetime Date/time (ISO 8601) the document was last modified
 * @property string $lastmodifieduser The user who last modified this document.
 * @property string $observationdatetime Date/time the observation was taken
 * @property string $outboundonly If the call made in the patient case is outbound
 * @property string $patientcaseid The patient case id
 * @property int $patientid The athenaNet patient ID.
 * @property string $priority Document priority, when available. 1 is high, 2 is normal. Some labs use other numbers or characters that are lab-specific.
 * @property int $providerid Provider ID for this document
 * @property string $providerusername The username of the provider associated with this lab result document.
 * @property string $status Status of the document
 * @property string $subject Subject of the document
 * @property int $tietoorderid Order ID of the order this document is tied to, if any
 */
class PatientCaseApi extends Model
{

    public $actionnote;
    public $assignedto;
    public $callbackname;
    public $callbacknumber;
    public $callbacknumbertype;
    public $calltype;
    public $clinicalproviderid;
    public $createddate;
    public $createddatetime;
    public $createddocuments;
    public $createduser;
    public $deleteddatetime;
    public $departmentid;
    public $description;
    public $documentclass;
    public $documentdescription;
    public $documentroute;
    public $documentsource;
    public $documentsubclass;
    public $documenttypeid;
    public $encounterid;
    public $externalaccessionid;
    public $externalnote;
    public $facilityid;
    public $internalaccessionid;
    public $internalnote;
    public $lastmodifieddate;
    public $lastmodifieddatetime;
    public $lastmodifieduser;
    public $observationdatetime;
    public $outboundonly;
    public $patientcaseid;
    public $patientid;
    public $priority;
    public $providerid;
    public $providerusername;
    public $status;
    public $subject;
    public $tietoorderid;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'callbackname', 'callbacknumber', 'callbacknumbertype', 'calltype', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdatetime', 'outboundonly', 'patientcaseid', 'priority', 'providerusername', 'status', 'subject'], 'trim'],
            [['actionnote', 'assignedto', 'callbackname', 'callbacknumber', 'callbacknumbertype', 'calltype', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdatetime', 'outboundonly', 'patientcaseid', 'priority', 'providerusername', 'status', 'subject'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
