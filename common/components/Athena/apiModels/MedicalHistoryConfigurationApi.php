<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property float $totalcount Quetion quatity
 * @property MedicalHistoryConfigurationQuestion[] $questions A complex JSON object containing the patient medical history. See the Chart documentation for more details.
 */
class MedicalHistoryConfigurationApi extends BaseApiModel
{

    public $totalcount;
    public $questions;
 
    protected $_questionsAr;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->questions) && is_array($this->questions)) {
            foreach($this->questions as $questions) {
                $this->_questionsAr[] = new MedicalHistoryConfigurationQuestionApi($questions);
            }
            $this->questions = $this->_questionsAr;
            $this->_questionsAr = [];//CHECKME
        }
    }

}
