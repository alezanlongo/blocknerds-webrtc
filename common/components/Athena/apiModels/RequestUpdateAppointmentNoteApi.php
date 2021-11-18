<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property bool $displayonschedule Add appointment note to homepage display.
 * @property string $notetext The note text.
 */
class RequestUpdateAppointmentNoteApi extends BaseApiModel
{

    public $displayonschedule;
    public $notetext;

    public function rules()
    {
        return [
            [['notetext'], 'trim'],
            [['notetext'], 'required'],
            [['notetext'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
