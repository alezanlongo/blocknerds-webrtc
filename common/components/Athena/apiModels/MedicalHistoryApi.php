<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property MedicalHistoryQuestion[] $questions List of questions corresponding to patient medical history
 * @property string $sectionnote Additional notes for the entire medical history section, if any
 */
class MedicalHistoryApi extends BaseApiModel
{

    public $questions;
 
    protected $_questionsAr;
    public $sectionnote;

    public function rules()
    {
        return [
            [['sectionnote'], 'trim'],
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
