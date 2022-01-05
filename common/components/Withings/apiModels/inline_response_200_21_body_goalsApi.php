<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $steps Number of steps per day.
 * @property int $sleep Sleep duration (in seconds).
 * @property inline_response_200_21_body_goals_weight $weight Weight.
 */
class inline_response_200_21_body_goalsApi extends BaseApiModel
{

    public $steps;
    public $sleep;
    public $weight;

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
