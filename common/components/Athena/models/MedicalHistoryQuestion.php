<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $answer The answer given by the patient to the question
 * @property string $codeset Codeset the diagnosis code belongs to
 * @property string $description Description of the code
 * @property string $diagnosiscode Diagnosis code
 * @property string $note Any special notes
 * @property string $question Disease being inquired about
 * @property float $questionid Athena ID for the question
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicalHistoryQuestion extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%medical_history_questions}}';
    }

    public function rules()
    {
        return [
            [['answer', 'codeset', 'description', 'diagnosiscode', 'note', 'question'], 'trim'],
            [['answer', 'codeset', 'description', 'diagnosiscode', 'note', 'question'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($answer = ArrayHelper::getValue($apiObject, 'answer')) {
            $this->answer = $answer;
        }
        if($codeset = ArrayHelper::getValue($apiObject, 'codeset')) {
            $this->codeset = $codeset;
        }
        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
        }
        if($diagnosiscode = ArrayHelper::getValue($apiObject, 'diagnosiscode')) {
            $this->diagnosiscode = $diagnosiscode;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($question = ArrayHelper::getValue($apiObject, 'question')) {
            $this->question = $question;
        }
        if($questionid = ArrayHelper::getValue($apiObject, 'questionid')) {
            $this->questionid = $questionid;
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
