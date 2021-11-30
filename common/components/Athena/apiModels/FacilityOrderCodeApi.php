<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code The code in the facility specific vocabulary.
 * @property string $description When available, a description of the code from the facility specific vocabulary.
 */
class FacilityOrderCodeApi extends BaseApiModel
{

    public $code;
    public $description;

    public function rules()
    {
        return [
            [['code', 'description'], 'trim'],
            [['code', 'description'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
