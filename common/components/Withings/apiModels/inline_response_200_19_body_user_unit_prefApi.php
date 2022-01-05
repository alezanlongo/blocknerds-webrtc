<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * User's unit preferences (cf. [Unit preferences](#section/Models/Unit-preferences) model).
 *
 * @property int $weight
 * @property int $height
 * @property int $temperature
 * @property int $distance
 */
class inline_response_200_19_body_user_unit_prefApi extends BaseApiModel
{

    public $weight;
    public $height;
    public $temperature;
    public $distance;

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
