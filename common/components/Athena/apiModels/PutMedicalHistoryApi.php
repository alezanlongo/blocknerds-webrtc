<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $departmentid The athenaNet department ID.
 * @property MedicalHistoryQuestion[] $questions A complex JSON object containing the patient medical history. See the Chart documentation for more details.
 * @property string $sectionnote Any additional section notes
 */
class PutMedicalHistoryApi extends BaseApiModel
{

    public $departmentid;
    public $questions;
 
    protected $_questionsAr;
    public $sectionnote;

    public function rules()
    {
        return [
            [['sectionnote'], 'trim'],
            [['departmentid'], 'required'],
            [['sectionnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->questions) && is_array($this->questions)) {
            foreach($this->questions as $questions) {
                $this->_questionsAr[] = new MedicalHistoryQuestionApi($questions);
            }
            $this->questions = $this->_questionsAr;
            $this->_questionsAr = [];//CHECKME
        }
    }

}
