<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property inline_response_200_7_body_user $user
 * @property dropshipment_create_order_object[] $orders List of created orders. *(Only if orders were successfully created)*
 * @property array $invalid_address_customer_ref_ids References of the orders with invalid address. *(Only if at least one order has an invalid address)*
 */
class inline_response_200_7_bodyApi extends BaseApiModel
{

    public $user;
    public $orders;
 
    protected $_ordersAr;
    public $invalid_address_customer_ref_ids;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->orders) && is_array($this->orders)) {
            foreach($this->orders as $orders) {
                $this->_ordersAr[] = new dropshipment_create_order_objectApi($orders);
            }
            $this->orders = $this->_ordersAr;
            $this->_ordersAr = [];//CHECKME
        }
    }

}
