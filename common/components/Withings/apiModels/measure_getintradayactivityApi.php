<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property object $series
 */
class measure_getintradayactivityApi extends BaseApiModel
{

    public $series;

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
