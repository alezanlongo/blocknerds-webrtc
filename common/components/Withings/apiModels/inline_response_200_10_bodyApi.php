<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property array $signal Signal value in micro-volt (μV).
 * @property int $sampling_frequency Signal Sampling Frequency (Hz).
 * @property int $wearposition Where the user is wearing the device.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Right Wrist|
 * |1 | Left Wrist|
 * |2 | Right Arm|
 * |3 | Left Arm|
 * |4 | Right Foot|
 * |5 | Left Foot|
 * |6 | Between Legs|
 */
class inline_response_200_10_bodyApi extends BaseApiModel
{

    public $signal;
    public $sampling_frequency;
    public $wearposition;

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
