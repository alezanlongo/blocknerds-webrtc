<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property array $icd10codes ICD-10 code(s) for this diagnosis.
 * @property array $icd9codes ICD-9 code(s) for this diagnosis.
 * @property string $laterality Laterality of the SNOMED code.
 * @property string $note The note to be entered for this diagnosis.
 * @property int $snomedcode SNOMED code for this diagnosis.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateDiagnosis extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_diagnoses}}';
    }

    public function rules()
    {
        return [
            [['laterality', 'note'], 'trim'],
            [['snomedcode'], 'required'],
            [['laterality', 'note'], 'string'],
            [['snomedcode', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($icd10codes = ArrayHelper::getValue($apiObject, 'icd10codes')) {
            $this->icd10codes = $icd10codes;
        }
        if($icd9codes = ArrayHelper::getValue($apiObject, 'icd9codes')) {
            $this->icd9codes = $icd9codes;
        }
        if($laterality = ArrayHelper::getValue($apiObject, 'laterality')) {
            $this->laterality = $laterality;
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
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
