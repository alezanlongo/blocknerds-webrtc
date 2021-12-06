<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $clinicalproviderid The ID of the external provider/lab/pharmacy associated the document.
 * @property int $documenttypeid A specific document type identifier.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes if replaceinternalnote is not set.
 * @property string $observationdate The date an observation was made (mm/dd/yyyy).
 * @property string $observationtime The time an observation was made (hh24:mi).  24 hour time.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property bool $replaceinternalnote If true, will replace the existing internal note with the new one. If false, will append to the existing note.
 */
class PutClinicalDocumentApi extends BaseApiModel
{

    public $clinicalproviderid;
    public $documenttypeid;
    public $internalnote;
    public $observationdate;
    public $observationtime;
    public $priority;
    public $providerid;
    public $replaceinternalnote;

    public function rules()
    {
        return [
            [['internalnote', 'observationdate', 'observationtime', 'priority'], 'trim'],
            [['internalnote', 'observationdate', 'observationtime', 'priority'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
