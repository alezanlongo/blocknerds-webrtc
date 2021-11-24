<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $medication The name of the medication
 * @property int $medicationid The athena ID of the medication
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicationReference extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%medication_references}}';
    }

    public function rules()
    {
        return [
            [['medication'], 'trim'],
            [['medication'], 'string'],
            [['medicationid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($medication = ArrayHelper::getValue($apiObject, 'medication')) {
            $this->medication = $medication;
        }
        if($medicationid = ArrayHelper::getValue($apiObject, 'medicationid')) {
            $this->medicationid = $medicationid;
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
