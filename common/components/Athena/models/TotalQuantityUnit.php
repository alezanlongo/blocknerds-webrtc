<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $quantityunit The unit for individual dosage and total quantities.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class TotalQuantityUnit extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%total_quantity_units}}';
    }

    public function rules()
    {
        return [
            [['quantityunit'], 'trim'],
            [['quantityunit'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($quantityunit = ArrayHelper::getValue($apiObject, 'quantityunit')) {
            $this->quantityunit = $quantityunit;
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
