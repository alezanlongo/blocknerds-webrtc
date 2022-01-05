<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $signalid Id of the signal.
 * @property int $afib Atrial fibrillation classification.
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Negative|
 * |1 | Positive|
 * |2 | Inconclusive|
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class heart_measurement_object_ecg extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%heart_measurement_object_ecgs}}';
    }

    public function rules()
    {
        return [
            [['signalid', 'afib', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($signalid = ArrayHelper::getValue($apiObject, 'signalid')) {
            $this->signalid = $signalid;
        }
        if($afib = ArrayHelper::getValue($apiObject, 'afib')) {
            $this->afib = $afib;
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
