<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $order_id Withings generated identifier used to track your order.
 * @property string $customer_ref_id Random identifier you must provide in input parameters. It is used to track your order and must be unique.
 * @property string $status Status of the order. Value can be:
 * 
 * 
 * | Value|
 * |---|
 * |CREATED|
 * |ADDRESS VERIFICATION|
 * |ADDRESS ERROR|
 * |VERIFIED|
 * |PROCESSING|
 * |FAILED|
 * |OPEN|
 * |SHIPPED|
 * |TRASHED|
 * |BACKHOLD|
 * @property dropshipment_create_order_product_object[] $products
 */
class dropshipment_create_order_objectApi extends BaseApiModel
{

    public $order_id;
    public $customer_ref_id;
    public $status;
    public $products;
 
    protected $_productsAr;

    public function rules()
    {
        return [
            [['order_id', 'customer_ref_id', 'status'], 'trim'],
            [['order_id', 'customer_ref_id', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->products) && is_array($this->products)) {
            foreach($this->products as $products) {
                $this->_productsAr[] = new dropshipment_create_order_product_objectApi($products);
            }
            $this->products = $this->_productsAr;
            $this->_productsAr = [];//CHECKME
        }
    }

}
