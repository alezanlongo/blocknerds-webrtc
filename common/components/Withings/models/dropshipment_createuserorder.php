<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property integer $user_id
 * @property dropshipment_user $user
 * @property dropshipment_create_order_object[] $orders List of created orders. *(Only if orders were successfully created)*
 * @property array $invalid_address_customer_ref_ids References of the orders with invalid address. *(Only if at least one order has an invalid address)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class dropshipment_createuserorder extends \yii\db\ActiveRecord
{
 
    protected $_ordersAr;

    public static function tableName()
    {
        return '{{%wth_dropshipment_createuserorders}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getUser()
    {
        return $this->hasOne(dropshipment_user::class, ['id' => 'user_id']);
    }

    public function getOrders()
    {
        return $this->hasMany(dropshipment_create_order_object::class, ['dropshipment_createuserorder_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($user_id = ArrayHelper::getValue($apiObject, 'user_id')) {
            $this->user_id = $user_id;
        }
        if($user = ArrayHelper::getValue($apiObject, 'user')) {
            $this->user = $user;
        }
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
                $dropshipment_create_order_object->link('dropshipmentCreateuserorder', $this);
                $dropshipment_create_order_object->save();
            }
        }

        return $saved;
    }
    */
}
