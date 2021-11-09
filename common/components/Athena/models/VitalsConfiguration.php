<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $abbreviation Short human-readable string for this vital group. E.g., Ht.
 * @property array $attributes List of vital attributes in this vital group. Contains all possible attributes even if there are no readings.
 * @property string $istiedtomeasurement If true, this vital is tied to some measurement.
 * @property string $key Key for this vital group. E.g., HEIGHT.
 * @property int $ordering Configured order for this vital group
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class VitalsConfiguration extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%vitals_configurations}}';
    }

    public function rules()
    {
        return [
            [['abbreviation', 'istiedtomeasurement', 'key'], 'trim'],
            [['abbreviation', 'istiedtomeasurement', 'key'], 'string'],
            [['ordering', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($abbreviation = ArrayHelper::getValue($apiObject, 'abbreviation')) {
            $this->abbreviation = $abbreviation;
        }
        if($attributes = ArrayHelper::getValue($apiObject, 'attributes')) {
            $this->attributes = $attributes;
        }
        if($istiedtomeasurement = ArrayHelper::getValue($apiObject, 'istiedtomeasurement')) {
            $this->istiedtomeasurement = $istiedtomeasurement;
        }
        if($key = ArrayHelper::getValue($apiObject, 'key')) {
            $this->key = $key;
        }
        if($ordering = ArrayHelper::getValue($apiObject, 'ordering')) {
            $this->ordering = $ordering;
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
