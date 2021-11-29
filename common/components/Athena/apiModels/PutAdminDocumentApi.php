<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $adminid The document ID of the edited document.
 * @property string $documentdate The date an observation was made (mm/dd/yyyy).
 * @property int $documenttypeid A specific document type identifier.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 */
class PutAdminDocumentApi extends BaseApiModel
{

    public $adminid;
    public $documentdate;
    public $documenttypeid;
    public $internalnote;
    public $priority;
    public $providerid;

    public function rules()
    {
        return [
            [['documentdate', 'internalnote', 'priority'], 'trim'],
            [['documentdate', 'internalnote', 'priority'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
