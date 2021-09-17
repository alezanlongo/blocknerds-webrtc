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
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->description = ArrayHelper::getValue($apiObject, 'description');
        $this->diagnosisid = ArrayHelper::getValue($apiObject, 'diagnosisid');
        $this->icdcodes = ArrayHelper::getValue($apiObject, 'icdcodes');
        $this->note = ArrayHelper::getValue($apiObject, 'note');
        $this->snomedcode = ArrayHelper::getValue($apiObject, 'snomedcode');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
