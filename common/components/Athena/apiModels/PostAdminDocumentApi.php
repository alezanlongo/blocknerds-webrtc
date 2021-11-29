<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class PostAdminDocumentApi extends BaseApiModel
{

    public $attachmentcontents;
    public $attachmenttype;
    public $autoclose;
    public $departmentid;
    public $documentdata;
    public $documentdate;
    public $documentsubclass;
    public $documenttypeid;
    public $entityid;
    public $entitytype;
    public $internalnote;
    public $originalfilename;
    public $priority;
    public $providerid;

    public function rules()
    {
        return [
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentdate', 'documentsubclass', 'entityid', 'entitytype', 'internalnote', 'originalfilename', 'priority'], 'trim'],
            [['departmentid', 'documentsubclass'], 'required'],
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentdate', 'documentsubclass', 'entityid', 'entitytype', 'internalnote', 'originalfilename', 'priority'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
