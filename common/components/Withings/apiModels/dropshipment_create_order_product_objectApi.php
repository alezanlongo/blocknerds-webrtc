<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $ean EAN of the product.
 * @property int $quantity Quantity of products.
 */
class dropshipment_create_order_product_objectApi extends BaseApiModel
{

    public $ean;
    public $quantity;

    public function rules()
    {
        return [
            [['ean'], 'trim'],
            [['ean'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
