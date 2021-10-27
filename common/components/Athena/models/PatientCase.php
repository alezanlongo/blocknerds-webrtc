<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PatientCase extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%patient_cases}}';
    }

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'callbackname', 'callbacknumber', 'callbacknumbertype', 'calltype', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdatetime', 'outboundonly', 'patientcaseid', 'priority', 'providerusername', 'status', 'subject'], 'trim'],
            [['actionnote', 'assignedto', 'callbackname', 'callbacknumber', 'callbacknumbertype', 'calltype', 'createddate', 'createddatetime', 'createduser', 'deleteddatetime', 'departmentid', 'description', 'documentclass', 'documentdescription', 'documentroute', 'documentsource', 'documentsubclass', 'encounterid', 'externalaccessionid', 'externalnote', 'internalaccessionid', 'internalnote', 'lastmodifieddate', 'lastmodifieddatetime', 'lastmodifieduser', 'observationdatetime', 'outboundonly', 'patientcaseid', 'priority', 'providerusername', 'status', 'subject'], 'string'],
            [['clinicalproviderid', 'documenttypeid', 'facilityid', 'patientid', 'providerid', 'tietoorderid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
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
        if($callbackname = ArrayHelper::getValue($apiObject, 'callbackname')) {
            $this->callbackname = $callbackname;
        }
        if($callbacknumber = ArrayHelper::getValue($apiObject, 'callbacknumber')) {
            $this->callbacknumber = $callbacknumber;
        }
        if($callbacknumbertype = ArrayHelper::getValue($apiObject, 'callbacknumbertype')) {
            $this->callbacknumbertype = $callbacknumbertype;
        }
        if($calltype = ArrayHelper::getValue($apiObject, 'calltype')) {
            $this->calltype = $calltype;
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
        if($createddocuments = ArrayHelper::getValue($apiObject, 'createddocuments')) {
            $this->createddocuments = $createddocuments;
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
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->encounterid = $encounterid;
        }
        if($externalaccessionid = ArrayHelper::getValue($apiObject, 'externalaccessionid')) {
            $this->externalaccessionid = $externalaccessionid;
        }
        if($externalnote = ArrayHelper::getValue($apiObject, 'externalnote')) {
            $this->externalnote = $externalnote;
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
        if($lastmodifieddate = ArrayHelper::getValue($apiObject, 'lastmodifieddate')) {
            $this->lastmodifieddate = $lastmodifieddate;
        }
        if($lastmodifieddatetime = ArrayHelper::getValue($apiObject, 'lastmodifieddatetime')) {
            $this->lastmodifieddatetime = $lastmodifieddatetime;
        }
        if($lastmodifieduser = ArrayHelper::getValue($apiObject, 'lastmodifieduser')) {
            $this->lastmodifieduser = $lastmodifieduser;
        }
        if($observationdatetime = ArrayHelper::getValue($apiObject, 'observationdatetime')) {
            $this->observationdatetime = $observationdatetime;
        }
        if($outboundonly = ArrayHelper::getValue($apiObject, 'outboundonly')) {
            $this->outboundonly = $outboundonly;
        }
        if($patientcaseid = ArrayHelper::getValue($apiObject, 'patientcaseid')) {
            $this->patientcaseid = $patientcaseid;
        }
        if($patientcaseid = ArrayHelper::getValue($apiObject, 'patientcaseid')) {
            $this->externalId = $patientcaseid;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
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

        return $saved;
    }
    */
}
