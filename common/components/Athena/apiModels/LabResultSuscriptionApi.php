<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $eventname Name of event
 */
class LabResultSuscriptionApi extends BaseApiModel
{

    public $eventname;

    public function rules()
    {
        return [
            [['eventname'], 'trim'],
            [['eventname'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
