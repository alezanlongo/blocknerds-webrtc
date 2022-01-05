<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property dropshipment_get_order_status_object[] $orders
 */
class inline_response_200_8_bodyApi extends BaseApiModel
{

    public $orders;
 
    protected $_ordersAr;

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
                $this->_ordersAr[] = new dropshipment_get_order_status_objectApi($orders);
            }
            $this->orders = $this->_ordersAr;
            $this->_ordersAr = [];//CHECKME
        }
    }

}
