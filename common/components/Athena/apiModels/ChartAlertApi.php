<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $lastmodified The time this note was updated (mm/dd/yyyy hh24:mi:ss; Eastern time), if the note has been updated.
 * @property string $lastmodifiedby If the note has been modified, the username who last modified this note.
 * @property string $notetext The text of the note.
 */
class ChartAlertApi extends BaseApiModel
{

    public $lastmodified;
    public $lastmodifiedby;
    public $notetext;

    public function rules()
    {
        return [
            [['lastmodified', 'lastmodifiedby', 'notetext'], 'trim'],
            [['lastmodified', 'lastmodifiedby', 'notetext'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
