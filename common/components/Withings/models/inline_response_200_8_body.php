<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property dropshipment_get_order_status_object[] $orders
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_8_body extends \yii\db\ActiveRecord
{
 
    protected $_ordersAr;

    public static function tableName()
    {
        return '{{%inline_response_200_8_bodies}}';
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
        return $this->hasMany(dropshipment_get_order_status_object::class, ['inline_response_200_8_body_id' => 'id']);
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
                $dropshipment_get_order_status_object->link('inlineResponse2008Body', $this);
                $dropshipment_get_order_status_object->save();
            }
        }

        return $saved;
    }
    */
}
