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
 * @property dropshipment_get_order_status_product_object[] $products
 * @property string $carrier Carrier. *(Only if order has been shipped)*
 * @property string $carrier_service Carrier service. *(Only if order has been shipped)*
 * @property string $tracking_number Tracking number. *(Only if order has been shipped)*
 * @property string $parcel_status Status of the parcel. *(Only if order has been shipped)* Value can be:
 * 
 * 
 * | Value|
 * |---|
 * |pending|
 * |info_received|
 * |in_transit|
 * |failed_attempt|
 * |exception|
 * |delayed|
 * |pickup|
 * |delivered|
 * |return|
 * |expired|
 */
class dropshipment_get_order_status_objectApi extends BaseApiModel
{

    public $order_id;
    public $customer_ref_id;
    public $status;
    public $products;
 
    protected $_productsAr;
    public $carrier;
    public $carrier_service;
    public $tracking_number;
    public $parcel_status;

    public function rules()
    {
        return [
            [['order_id', 'customer_ref_id', 'status', 'carrier', 'carrier_service', 'tracking_number', 'parcel_status'], 'trim'],
            [['order_id', 'customer_ref_id', 'status', 'carrier', 'carrier_service', 'tracking_number', 'parcel_status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->products) && is_array($this->products)) {
            foreach($this->products as $products) {
                $this->_productsAr[] = new dropshipment_get_order_status_product_objectApi($products);
            }
            $this->products = $this->_productsAr;
            $this->_productsAr = [];//CHECKME
        }
    }

}
