<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class dropshipment_get_order_status_object extends \yii\db\ActiveRecord
{
 
    protected $_productsAr;

    public static function tableName()
    {
        return '{{%dropshipment_get_order_status_objects}}';
    }

    public function rules()
    {
        return [
            [['order_id', 'customer_ref_id', 'status', 'carrier', 'carrier_service', 'tracking_number', 'parcel_status'], 'trim'],
            [['order_id', 'customer_ref_id', 'status', 'carrier', 'carrier_service', 'tracking_number', 'parcel_status'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(dropshipment_get_order_status_product_object::class, ['dropshipment_get_order_status_object_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($order_id = ArrayHelper::getValue($apiObject, 'order_id')) {
            $this->order_id = $order_id;
        }
        if($customer_ref_id = ArrayHelper::getValue($apiObject, 'customer_ref_id')) {
            $this->customer_ref_id = $customer_ref_id;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($products = ArrayHelper::getValue($apiObject, 'products')) {
            $this->_productsAr = $products;
        }
        if($carrier = ArrayHelper::getValue($apiObject, 'carrier')) {
            $this->carrier = $carrier;
        }
        if($carrier_service = ArrayHelper::getValue($apiObject, 'carrier_service')) {
            $this->carrier_service = $carrier_service;
        }
        if($tracking_number = ArrayHelper::getValue($apiObject, 'tracking_number')) {
            $this->tracking_number = $tracking_number;
        }
        if($parcel_status = ArrayHelper::getValue($apiObject, 'parcel_status')) {
            $this->parcel_status = $parcel_status;
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
        if( !empty($this->_productsAr) and is_array($this->_productsAr) ) {
            foreach($this->_productsAr as $productsApi) {
                $dropshipment_get_order_status_product_object = new dropshipment_get_order_status_product_object();
                $dropshipment_get_order_status_product_object->loadApiObject($productsApi);
                $dropshipment_get_order_status_product_object->link('dropshipmentGetOrderStatusObject', $this);
                $dropshipment_get_order_status_product_object->save();
            }
        }

        return $saved;
    }
    */
}
