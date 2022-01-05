<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $value Value for the measure in S.I. units (kilograms, meters etc...). Value should be multiplied by 10 to the power of ```units``` to get the real value.
 * @property int $type Type of the measure. See ```meastype``` input parameter.
 * @property int $unit Power of ten to multiply the ```value``` field to get the real value.<br>Formula: ```value * 10^unit = real value```.<br>Eg: ```value = 20 and unit = -1 => real value = 2```.
 * @property int $algo Deprecated.
 * @property int $fm Deprecated.
 * @property int $fw Deprecated.
 */
class measure_objectApi extends BaseApiModel
{

    public $value;
    public $type;
    public $unit;
    public $algo;
    public $fm;
    public $fw;

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
