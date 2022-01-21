<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property dropshipment_get_order_status_object[] $orders
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class dropshipment_getorderstatus extends \yii\db\ActiveRecord
{
 
    protected $_ordersAr;

    public static function tableName()
    {
        return '{{%wth_dropshipment_getorderstatuses}}';
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
        return $this->hasMany(dropshipment_get_order_status_object::class, ['dropshipment_getorderstatus_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($orders = ArrayHelper::getValue($apiObject, 'orders')) {
            $this->_ordersAr = $orders;
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
                $dropshipment_get_order_status_object = new dropshipment_get_order_status_object();
                $dropshipment_get_order_status_object->loadApiObject($ordersApi);
                $dropshipment_get_order_status_object->link('dropshipmentGetorderstatus', $this);
                $dropshipment_get_order_status_object->save();
            }
        }

        return $saved;
    }
    */
}
