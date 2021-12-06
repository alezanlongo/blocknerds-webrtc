<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $name The name of the order
 * @property int $ordertypeid The athena ID of the type of order
 */
class OrderableLabApi extends BaseApiModel
{

    public $name;
    public $ordertypeid;

    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
