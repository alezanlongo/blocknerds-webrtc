<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property object $diagnosiscode
 * @property array $snomedicdcodes ICD equivalent Codes for the SNOMED Code
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class DiagnosisList extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%diagnosis_lists}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($diagnosiscode = ArrayHelper::getValue($apiObject, 'diagnosiscode')) {
            $this->diagnosiscode = $diagnosiscode;
        }
        if($snomedicdcodes = ArrayHelper::getValue($apiObject, 'snomedicdcodes')) {
            $this->snomedicdcodes = $snomedicdcodes;
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
