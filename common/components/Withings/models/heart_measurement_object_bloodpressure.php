<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $diastole Diastole value.
 * @property int $systole Systole value.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class heart_measurement_object_bloodpressure extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_heart_measurement_object_bloodpressures}}';
    }

    public function rules()
    {
        return [
            [['diastole', 'systole', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($diastole = ArrayHelper::getValue($apiObject, 'diastole')) {
            $this->diastole = $diastole;
        }
        if($systole = ArrayHelper::getValue($apiObject, 'systole')) {
            $this->systole = $systole;
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
