<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $deleted True if this question has been deleted
 * @property string $diagnosiscode Diagnosis code for the disease, if provided
 * @property float $ordering Used for re-ordering questions
 * @property string $question Disease being inquired about
 * @property float $questionid Athena ID for the question
 * @property string $answer The answer given by the patient to the question (added for the aplication)
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicalHistoryConfigurationQuestion extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%medical_history_configuration_questions}}';
    }

    public function rules()
    {
        return [
            [['deleted', 'diagnosiscode', 'question', 'answer'], 'trim'],
            [['deleted', 'diagnosiscode', 'question', 'answer'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($deleted = ArrayHelper::getValue($apiObject, 'deleted')) {
            $this->deleted = $deleted;
        }
        if($diagnosiscode = ArrayHelper::getValue($apiObject, 'diagnosiscode')) {
            $this->diagnosiscode = $diagnosiscode;
        }
        if($ordering = ArrayHelper::getValue($apiObject, 'ordering')) {
            $this->ordering = $ordering;
        }
        if($question = ArrayHelper::getValue($apiObject, 'question')) {
            $this->question = $question;
        }
        if($questionid = ArrayHelper::getValue($apiObject, 'questionid')) {
            $this->questionid = $questionid;
        }
        if($answer = ArrayHelper::getValue($apiObject, 'answer')) {
            $this->answer = $answer;
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
