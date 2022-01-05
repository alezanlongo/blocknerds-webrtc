<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * User's unit preferences (cf. [Unit preferences](#section/Models/Unit-preferences) model). *
 * @property int $weight
 * @property int $height
 * @property int $temperature
 * @property int $distance
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_19_body_user_unit_pref extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_19_body_user_unit_prefs}}';
    }

    public function rules()
    {
        return [
            [['weight', 'height', 'temperature', 'distance', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($weight = ArrayHelper::getValue($apiObject, 'weight')) {
            $this->weight = $weight;
        }
        if($height = ArrayHelper::getValue($apiObject, 'height')) {
            $this->height = $height;
        }
        if($temperature = ArrayHelper::getValue($apiObject, 'temperature')) {
            $this->temperature = $temperature;
        }
        if($distance = ArrayHelper::getValue($apiObject, 'distance')) {
            $this->distance = $distance;
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
