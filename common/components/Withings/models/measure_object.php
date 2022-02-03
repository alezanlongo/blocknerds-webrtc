<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $value Value for the measure in S.I. units (kilograms, meters etc...). Value should be multiplied by 10 to the power of ```units``` to get the real value.
 * @property int $type Type of the measure. See ```meastype``` input parameter.
 * @property int $unit Power of ten to multiply the ```value``` field to get the real value.<br>Formula: ```value * 10^unit = real value```.<br>Eg: ```value = 20 and unit = -1 => real value = 2```.
 * @property int $algo Deprecated.
 * @property int $fm Deprecated.
 * @property int $fw Deprecated.
 * @property integer $measuregrp_object_id
 * @property measuregrp_object $measuregrp_object
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class measure_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_measure_objects}}';
    }

    public function rules()
    {
        return [
            [['value', 'type', 'unit', 'algo', 'fm', 'fw', 'measuregrp_object_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getMeasuregrp_object()
    {
        return $this->hasOne(measuregrp_object::class, ['id' => 'measuregrp_object_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($value = ArrayHelper::getValue($apiObject, 'value')) {
            $this->value = $value;
        }
        if($type = ArrayHelper::getValue($apiObject, 'type')) {
            $this->type = $type;
        }
        if($unit = ArrayHelper::getValue($apiObject, 'unit')) {
            $this->unit = $unit;
        }
        if($algo = ArrayHelper::getValue($apiObject, 'algo')) {
            $this->algo = $algo;
        }
        if($fm = ArrayHelper::getValue($apiObject, 'fm')) {
            $this->fm = $fm;
        }
        if($fw = ArrayHelper::getValue($apiObject, 'fw')) {
            $this->fw = $fw;
        }
        if($measuregrp_object_id = ArrayHelper::getValue($apiObject, 'measuregrp_object_id')) {
            $this->measuregrp_object_id = $measuregrp_object_id;
        }
        if($measuregrp_object = ArrayHelper::getValue($apiObject, 'measuregrp_object')) {
            $this->measuregrp_object = $measuregrp_object;
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
