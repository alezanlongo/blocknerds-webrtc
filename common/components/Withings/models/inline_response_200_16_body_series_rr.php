<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Respiration Rate. *(Use 'data_fields' to request this data.)* *
 * @property int $$timestamp $timestamp represents the epoch value of the respiration rate data, value of this key will be the respiration rate data
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_16_body_series_rr extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_16_body_series_rrs}}';
    }

    public function rules()
    {
        return [
            [['$timestamp', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($$timestamp = ArrayHelper::getValue($apiObject, '$timestamp')) {
            $this->$timestamp = $$timestamp;
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
