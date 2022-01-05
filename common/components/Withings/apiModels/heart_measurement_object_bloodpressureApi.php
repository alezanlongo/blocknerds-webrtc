<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $diastole Diastole value.
 * @property int $systole Systole value.
 */
class heart_measurement_object_bloodpressureApi extends BaseApiModel
{

    public $diastole;
    public $systole;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
