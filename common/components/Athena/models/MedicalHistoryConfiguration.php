<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property float $totalcount Quetion quatity
 * @property MedicalHistoryConfigurationQuestion[] $questions A complex JSON object containing the patient medical history. See the Chart documentation for more details.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicalHistoryConfiguration extends \yii\db\ActiveRecord
{
 
    protected $_questionsAr;

    public static function tableName()
    {
        return '{{%medical_history_configurations}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getQuestions()
    {
        return $this->hasMany(MedicalHistoryConfigurationQuestion::class, ['medical_history_configuration_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($totalcount = ArrayHelper::getValue($apiObject, 'totalcount')) {
            $this->totalcount = $totalcount;
        }
        if($questions = ArrayHelper::getValue($apiObject, 'questions')) {
            $this->_questionsAr = $questions;
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
                $medicalhistoryconfigurationquestion = new MedicalHistoryConfigurationQuestion();
                $medicalhistoryconfigurationquestion->loadApiObject($questionsApi);
                $medicalhistoryconfigurationquestion->link('medicalHistoryConfiguration', $this);
                $medicalhistoryconfigurationquestion->save();
            }
        }

        return $saved;
    }
    */
}
