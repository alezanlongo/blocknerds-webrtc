<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $quantityunit The unit for individual dosage and total quantities.
 */
class TotalQuantityUnitApi extends BaseApiModel
{

    public $quantityunit;

    public function rules()
    {
        return [
            [['quantityunit'], 'trim'],
            [['quantityunit'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
