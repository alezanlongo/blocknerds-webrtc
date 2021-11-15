<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $accessionid A unique identifier given to a document to track it over time.
 * @property array $analytes This is an array of hashes in JSON. Each entry contains information for a single analyte. See <a href="https://developer.athenahealth.com/docs/read/workflows/documents/Lab_Analytes">https://developer.athenahealth.com/docs/read/workflows/documents/Lab_Analytes</a> for an example.
 * @property string $attachmentcontents The file contents that will be attached to this document. PDFs and PNGs are supported file types. Other file types are available only for alpha partners. All files must be Base64 encoded.
 * @property string $attachmenttype The file type of attachment. PDFs and PNGs are supported. Other file types are available only for alpha partners
 * @property bool $autoclose Documents will, normally, automatically appear in the clinical inbox for providers to review. In some cases, you might want to force the document to skip the clinical inbox, and go directly to the patient chart with a "closed" status. For that case, set this to true.
 * @property int $departmentid The athenaNet department ID associated with the uploaded document.
 * @property int $documenttypeid A specific document type identifier.
 * @property int $facilityid The ID of the facility or clinical provider who received the order.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property string $interpretation The practice entered interpretation of this result. Updating this will append to any previous values.
 * @property string $notetopatient This is a note specifically for the patient to view or action on. Updating this will append to any previous notes.
 * @property string $observationdate The date an observation was made (mm/dd/yyyy).
 * @property string $observationtime The time an observation was made (hh24:mi).  24 hour time.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property string $reportstatus The status of the report.
 * @property string $resultnotes Result notes of a document.
 * @property string $resultstatus The status of the result.
 * @property string $specimenreceiveddatetime Date-time indicating when the specimen was received in format (yyyy-mm-ddThh:mm:ss).
 * @property string $specimenreporteddatetime Date-time indicating when the specimen was reported in format (yyyy-mm-ddThh:mm:ss).
 * @property int $tietoorderid Tie the result document to this order.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostLabResult extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_lab_results}}';
    }

    public function rules()
    {
        return [
            [['accessionid', 'attachmentcontents', 'attachmenttype', 'internalnote', 'interpretation', 'notetopatient', 'observationdate', 'observationtime', 'priority', 'reportstatus', 'resultnotes', 'resultstatus', 'specimenreceiveddatetime', 'specimenreporteddatetime'], 'trim'],
            [['departmentid'], 'required'],
            [['accessionid', 'attachmentcontents', 'attachmenttype', 'internalnote', 'interpretation', 'notetopatient', 'observationdate', 'observationtime', 'priority', 'reportstatus', 'resultnotes', 'resultstatus', 'specimenreceiveddatetime', 'specimenreporteddatetime'], 'string'],
            [['departmentid', 'documenttypeid', 'facilityid', 'providerid', 'tietoorderid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($accessionid = ArrayHelper::getValue($apiObject, 'accessionid')) {
            $this->accessionid = $accessionid;
        }
        if($analytes = ArrayHelper::getValue($apiObject, 'analytes')) {
            $this->analytes = $analytes;
        }
        if($attachmentcontents = ArrayHelper::getValue($apiObject, 'attachmentcontents')) {
            $this->attachmentcontents = $attachmentcontents;
        }
        if($attachmenttype = ArrayHelper::getValue($apiObject, 'attachmenttype')) {
            $this->attachmenttype = $attachmenttype;
        }
        if($autoclose = ArrayHelper::getValue($apiObject, 'autoclose')) {
            $this->autoclose = $autoclose;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($facilityid = ArrayHelper::getValue($apiObject, 'facilityid')) {
            $this->facilityid = $facilityid;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($interpretation = ArrayHelper::getValue($apiObject, 'interpretation')) {
            $this->interpretation = $interpretation;
        }
        if($notetopatient = ArrayHelper::getValue($apiObject, 'notetopatient')) {
            $this->notetopatient = $notetopatient;
        }
        if($observationdate = ArrayHelper::getValue($apiObject, 'observationdate')) {
            $this->observationdate = $observationdate;
        }
        if($observationtime = ArrayHelper::getValue($apiObject, 'observationtime')) {
            $this->observationtime = $observationtime;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($reportstatus = ArrayHelper::getValue($apiObject, 'reportstatus')) {
            $this->reportstatus = $reportstatus;
        }
        if($resultnotes = ArrayHelper::getValue($apiObject, 'resultnotes')) {
            $this->resultnotes = $resultnotes;
        }
        if($resultstatus = ArrayHelper::getValue($apiObject, 'resultstatus')) {
            $this->resultstatus = $resultstatus;
        }
        if($specimenreceiveddatetime = ArrayHelper::getValue($apiObject, 'specimenreceiveddatetime')) {
            $this->specimenreceiveddatetime = $specimenreceiveddatetime;
        }
        if($specimenreporteddatetime = ArrayHelper::getValue($apiObject, 'specimenreporteddatetime')) {
            $this->specimenreporteddatetime = $specimenreporteddatetime;
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
