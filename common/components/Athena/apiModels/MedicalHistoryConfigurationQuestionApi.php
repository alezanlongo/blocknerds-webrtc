<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $deleted True if this question has been deleted
 * @property string $diagnosiscode Diagnosis code for the disease, if provided
 * @property float $ordering Used for re-ordering questions
 * @property string $question Disease being inquired about
 * @property float $questionid Athena ID for the question
 * @property string $answer The answer given by the patient to the question (added for the aplication)
 */
class MedicalHistoryConfigurationQuestionApi extends BaseApiModel
{

    public $deleted;
    public $diagnosiscode;
    public $ordering;
    public $question;
    public $questionid;
    public $answer;

    public function rules()
    {
        return [
            [['deleted', 'diagnosiscode', 'question', 'answer'], 'trim'],
            [['deleted', 'diagnosiscode', 'question', 'answer'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
