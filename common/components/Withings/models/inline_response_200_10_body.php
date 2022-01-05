<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property array $signal Signal value in micro-volt (μV).
 * @property int $sampling_frequency Signal Sampling Frequency (Hz).
 * @property int $wearposition Where the user is wearing the device.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Right Wrist|
 * |1 | Left Wrist|
 * |2 | Right Arm|
 * |3 | Left Arm|
 * |4 | Right Foot|
 * |5 | Left Foot|
 * |6 | Between Legs|
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_10_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_10_bodies}}';
    }

    public function rules()
    {
        return [
            [['sampling_frequency', 'wearposition', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($signal = ArrayHelper::getValue($apiObject, 'signal')) {
            $this->signal = $signal;
        }
        if($sampling_frequency = ArrayHelper::getValue($apiObject, 'sampling_frequency')) {
            $this->sampling_frequency = $sampling_frequency;
        }
        if($wearposition = ArrayHelper::getValue($apiObject, 'wearposition')) {
            $this->wearposition = $wearposition;
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
