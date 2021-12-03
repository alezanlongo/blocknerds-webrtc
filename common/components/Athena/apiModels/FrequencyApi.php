<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $frequency dosage frequency
 */
class FrequencyApi extends BaseApiModel
{

    public $frequency;

    public function rules()
    {
        return [
            [['frequency'], 'trim'],
            [['frequency'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
