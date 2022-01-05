<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property dropshipment_create_order_object[] $orders List of created orders. *(Only if orders were successfully created)*
 * @property array $invalid_address_customer_ref_ids References of the orders with invalid address. *(Only if at least one order has an invalid address)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_6_body extends \yii\db\ActiveRecord
{
 
    protected $_ordersAr;

    public static function tableName()
    {
        return '{{%inline_response_200_6_bodies}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getOrders()
    {
        return $this->hasMany(dropshipment_create_order_object::class, ['inline_response_200_6_body_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($orders = ArrayHelper::getValue($apiObject, 'orders')) {
            $this->_ordersAr = $orders;
        }
        if($invalid_address_customer_ref_ids = ArrayHelper::getValue($apiObject, 'invalid_address_customer_ref_ids')) {
            $this->invalid_address_customer_ref_ids = $invalid_address_customer_ref_ids;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);
        if( !empty($this->_ordersAr) and is_array($this->_ordersAr) ) {
            foreach($this->_ordersAr as $ordersApi) {
                $dropshipment_create_order_object = new dropshipment_create_order_object();
                $dropshipment_create_order_object->loadApiObject($ordersApi);
                $dropshipment_create_order_object->link('inlineResponse2006Body', $this);
                $dropshipment_create_order_object->save();
            }
        }

        return $saved;
    }
    */
}
