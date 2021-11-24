<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class PostClinicalDocumentApi extends BaseApiModel
{

    public $attachmentcontents;
    public $attachmenttype;
    public $autoclose;
    public $clinicalproviderid;
    public $departmentid;
    public $documentdata;
    public $documentsubclass;
    public $documenttypeid;
    public $internalnote;
    public $observationdate;
    public $observationtime;
    public $priority;
    public $providerid;

    public function rules()
    {
        return [
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentsubclass', 'internalnote', 'observationdate', 'observationtime', 'priority'], 'trim'],
            [['departmentid', 'documentsubclass'], 'required'],
            [['attachmentcontents', 'attachmenttype', 'documentdata', 'documentsubclass', 'internalnote', 'observationdate', 'observationtime', 'priority'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
