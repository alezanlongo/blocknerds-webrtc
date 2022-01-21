<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $ean EAN of the product.
 * @property int $quantity Quantity of products.
 * @property array $mac_addresses List of device MAC addresses. *(Only if order has been shipped)*
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class dropshipment_get_order_status_product_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_dropshipment_get_order_status_product_objects}}';
    }

    public function rules()
    {
        return [
            [['ean'], 'trim'],
            [['ean'], 'string'],
            [['quantity', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($ean = ArrayHelper::getValue($apiObject, 'ean')) {
            $this->ean = $ean;
        }
        if($quantity = ArrayHelper::getValue($apiObject, 'quantity')) {
            $this->quantity = $quantity;
        }
        if($mac_addresses = ArrayHelper::getValue($apiObject, 'mac_addresses')) {
            $this->mac_addresses = $mac_addresses;
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

        return $saved;
    }
    */
}
