<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property MedicalHistoryQuestion[] $questions List of questions corresponding to patient medical history
 * @property string $sectionnote Additional notes for the entire medical history section, if any
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicalHistory extends \yii\db\ActiveRecord
{
 
    protected $_questionsAr;

    public static function tableName()
    {
        return '{{%medical_histories}}';
    }

    public function rules()
    {
        return [
            [['sectionnote'], 'trim'],
            [['sectionnote'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getQuestions()
    {
        return $this->hasMany(MedicalHistoryQuestion::class, ['medical_history_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($questions = ArrayHelper::getValue($apiObject, 'questions')) {
            $this->_questionsAr = $questions;
        }
        if($sectionnote = ArrayHelper::getValue($apiObject, 'sectionnote')) {
            $this->sectionnote = $sectionnote;
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
        if( !empty($this->_questionsAr) and is_array($this->_questionsAr) ) {
            foreach($this->_questionsAr as $questionsApi) {
                $medicalhistoryquestion = new MedicalHistoryQuestion();
                $medicalhistoryquestion->loadApiObject($questionsApi);
                $medicalhistoryquestion->link('medicalHistory', $this);
                $medicalhistoryquestion->save();
            }
        }

        return $saved;
    }
    */
}
