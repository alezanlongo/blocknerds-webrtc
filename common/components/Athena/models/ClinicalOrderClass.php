<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property float $clinicalorderclassid The clinical order class id
 * @property string $name The name for this clinical order class
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ClinicalOrderClass extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%clinical_order_classes}}';
    }

    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($clinicalorderclassid = ArrayHelper::getValue($apiObject, 'clinicalorderclassid')) {
            $this->clinicalorderclassid = $clinicalorderclassid;
        }
        if($name = ArrayHelper::getValue($apiObject, 'name')) {
            $this->name = $name;
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
