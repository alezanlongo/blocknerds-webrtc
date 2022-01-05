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
 * @property dropshipment_create_order_product_object[] $products
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class dropshipment_create_order_object extends \yii\db\ActiveRecord
{
 
    protected $_productsAr;

    public static function tableName()
    {
        return '{{%dropshipment_create_order_objects}}';
    }

    public function rules()
    {
        return [
            [['order_id', 'customer_ref_id', 'status'], 'trim'],
            [['order_id', 'customer_ref_id', 'status'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getProducts()
    {
        return $this->hasMany(dropshipment_create_order_product_object::class, ['dropshipment_create_order_object_id' => 'id']);
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
                $dropshipment_create_order_product_object = new dropshipment_create_order_product_object();
                $dropshipment_create_order_product_object->loadApiObject($productsApi);
                $dropshipment_create_order_product_object->link('dropshipmentCreateOrderObject', $this);
                $dropshipment_create_order_product_object->save();
            }
        }

        return $saved;
    }
    */
}
