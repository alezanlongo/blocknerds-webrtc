<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $attachmentcontents The file contents that will be attached to this document. PDFs and PNGs are supported file types. Other file types are available only for alpha partners. All files must be Base64 encoded.
 * @property string $attachmenttype The file type of attachment. PDFs and PNGs are supported. Other file types are available only for alpha partners
 * @property bool $autoclose Documents will, normally, automatically appear in the clinical inbox for providers to review. In some cases, you might want to force the document to skip the clinical inbox, and go directly to the patient chart with a "closed" status. For that case, set this to true.
 * @property int $clinicalproviderid The ID of the external provider/lab/pharmacy associated the document.
 * @property int $departmentid The athenaNet department ID associated with the uploaded document.
 * @property string $documentdata Text data stored with document
 * @property string $documentsubclass Subclasses for CLINICALDOCUMENT documents
 * @property int $documenttypeid A specific document type identifier.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property string $observationdate The date an observation was made (mm/dd/yyyy).
 * @property string $observationtime The time an observation was made (hh24:mi).  24 hour time.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property string $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostClinicalDocument extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_clinical_documents}}';
    }

    public function rules()
    {
        return [
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentsubclass', 'internalnote', 'observationdate', 'observationtime', 'priority', 'externalId'], 'trim'],
            [['departmentid', 'documentsubclass'], 'required'],
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentsubclass', 'internalnote', 'observationdate', 'observationtime', 'priority', 'externalId'], 'string'],
            [['clinicalproviderid', 'departmentid', 'documenttypeid', 'providerid', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($attachmentcontents = ArrayHelper::getValue($apiObject, 'attachmentcontents')) {
            $this->attachmentcontents = $attachmentcontents;
        }
        if($attachmenttype = ArrayHelper::getValue($apiObject, 'attachmenttype')) {
            $this->attachmenttype = $attachmenttype;
        }
        if($autoclose = ArrayHelper::getValue($apiObject, 'autoclose')) {
            $this->autoclose = $autoclose;
        }
        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($documentdata = ArrayHelper::getValue($apiObject, 'documentdata')) {
            $this->documentdata = $documentdata;
        }
        if($documentsubclass = ArrayHelper::getValue($apiObject, 'documentsubclass')) {
            $this->documentsubclass = $documentsubclass;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
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
