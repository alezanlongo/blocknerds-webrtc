<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Weight.
 *
 * @property int $value Value for the measure in S.I. units (kilograms, meters etc...). Value should be multiplied by 10 to the power of ```units``` to get the real value.
 * @property int $unit Power of ten to multiply the ```value``` field to get the real value.<br>Formula: ```value * 10^unit = real value```.<br>Eg: ```value = 20 and unit = -1 => real value = 2```.
 */
class inline_response_200_21_body_goals_weightApi extends BaseApiModel
{

    public $value;
    public $unit;

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
