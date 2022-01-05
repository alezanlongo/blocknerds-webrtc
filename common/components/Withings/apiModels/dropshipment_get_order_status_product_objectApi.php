<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $ean EAN of the product.
 * @property int $quantity Quantity of products.
 * @property array $mac_addresses List of device MAC addresses. *(Only if order has been shipped)*
 */
class dropshipment_get_order_status_product_objectApi extends BaseApiModel
{

    public $ean;
    public $quantity;
    public $mac_addresses;

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
