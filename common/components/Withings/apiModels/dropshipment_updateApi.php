<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property dropshipment_create_order_object[] $orders
 */
class dropshipment_updateApi extends BaseApiModel
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
                $this->_ordersAr[] = new dropshipment_create_order_objectApi($orders);
            }
            $this->orders = $this->_ordersAr;
            $this->_ordersAr = [];//CHECKME
        }
    }

}
