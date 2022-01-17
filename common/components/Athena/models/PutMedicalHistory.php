<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $departmentid The athenaNet department ID.
 * @property MedicalHistoryQuestion[] $questions A complex JSON object containing the patient medical history. See the Chart documentation for more details.
 * @property string $sectionnote Any additional section notes
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutMedicalHistory extends \yii\db\ActiveRecord
{
 
    protected $_questionsAr;

    public static function tableName()
    {
        return '{{%put_medical_histories}}';
    }

    public function rules()
    {
        return [
            [['sectionnote'], 'trim'],
            [['departmentid'], 'required'],
            [['sectionnote'], 'string'],
            [['departmentid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getQuestions()
    {
        return $this->hasMany(MedicalHistoryQuestion::class, ['put_medical_history_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
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
                $medicalhistoryquestion->link('putMedicalHistory', $this);
                $medicalhistoryquestion->save();
            }
        }

        return $saved;
    }
    */
}
