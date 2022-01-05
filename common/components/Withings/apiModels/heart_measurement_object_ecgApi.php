<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $signalid Id of the signal.
 * @property int $afib Atrial fibrillation classification.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Negative|
 * |1 | Positive|
 * |2 | Inconclusive|
 */
class heart_measurement_object_ecgApi extends BaseApiModel
{

    public $signalid;
    public $afib;

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
