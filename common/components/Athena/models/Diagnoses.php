<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $description Brief description for this SNOMED Code
 * @property int $diagnosisid Athena ID for this diagnosis
 * @property array $icdcodes List of relevant ICD codes for this diagnosis
 * @property string $note The note entered for this diagnosis.
 * @property int $snomedcode SNOMED Code for this diagnosis
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Diagnoses extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%diagnoses}}';
    }

    public function rules()
    {
        return [
            [['description', 'note'], 'trim'],
            [['description', 'note'], 'string'],
            [['diagnosisid', 'snomedcode', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($diagnosisid = ArrayHelper::getValue($apiObject, 'diagnosisid')) {
            $this->diagnosisid = $diagnosisid;
        }
        if($diagnosisid = ArrayHelper::getValue($apiObject, 'diagnosisid')) {
            $this->externalId = $diagnosisid;
        }
        if($icdcodes = ArrayHelper::getValue($apiObject, 'icdcodes')) {
            $this->icdcodes = $icdcodes;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($snomedcode = ArrayHelper::getValue($apiObject, 'snomedcode')) {
            $this->snomedcode = $snomedcode;
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

    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
}
