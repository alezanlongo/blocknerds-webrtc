<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $attachmentcontents The file contents that will be attached to this document. PDFs are recommended.
 * @property string $attachmenttype The file type of the attachment.
 * @property bool $autoclose Documents will, normally, automatically appear in the clinical inbox for providers to review. In some cases, you might want to force the document to skip the clinical inbox, and go directly to the patient chart with a "closed" status. For that case, set this to true.
 * @property int $departmentid The athenaNet department ID associated with the uploaded document.
 * @property string $documentdata Text data stored with document
 * @property string $documentdate The date an observation was made (mm/dd/yyyy).
 * @property string $documentsubclass Subclasses for ADMIN documents
 * @property int $documenttypeid A specific document type identifier.
 * @property string $entityid Identifier of entity creating the document. entitytype is required while passing entityid.
 * @property string $entitytype Type of entity creating the document. entityid is required while passing entitytype.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property string $originalfilename The original file name of this document without the file extension. Filename should not exceed 200 characters.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostAdminDocument extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_admin_documents}}';
    }

    public function rules()
    {
        return [
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentdate', 'documentsubclass', 'entityid', 'entitytype', 'internalnote', 'originalfilename', 'priority'], 'trim'],
            [['departmentid', 'documentsubclass'], 'required'],
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentdate', 'documentsubclass', 'entityid', 'entitytype', 'internalnote', 'originalfilename', 'priority'], 'string'],
            [['departmentid', 'documenttypeid', 'providerid', 'externalId', 'id'], 'integer'],
            [['autoclose'], 'boolean'],
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
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($documentdata = ArrayHelper::getValue($apiObject, 'documentdata')) {
            $this->documentdata = $documentdata;
        }
        if($documentdate = ArrayHelper::getValue($apiObject, 'documentdate')) {
            $this->documentdate = $documentdate;
        }
        if($documentsubclass = ArrayHelper::getValue($apiObject, 'documentsubclass')) {
            $this->documentsubclass = $documentsubclass;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($entityid = ArrayHelper::getValue($apiObject, 'entityid')) {
            $this->entityid = $entityid;
        }
        if($entitytype = ArrayHelper::getValue($apiObject, 'entitytype')) {
            $this->entitytype = $entitytype;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($originalfilename = ArrayHelper::getValue($apiObject, 'originalfilename')) {
            $this->originalfilename = $originalfilename;
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
