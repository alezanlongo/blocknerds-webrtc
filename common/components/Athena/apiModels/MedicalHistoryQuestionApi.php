<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property MedicalHistory $medicalHistory
 * @property string $answer The answer given by the patient to the question
 * @property string $codeset Codeset the diagnosis code belongs to
 * @property string $description Description of the code
 * @property string $diagnosiscode Diagnosis code
 * @property string $note Any special notes
 * @property string $question Disease being inquired about
 * @property float $questionid Athena ID for the question
 */
class MedicalHistoryQuestionApi extends BaseApiModel
{

    public $medicalHistory;
    public $answer;
    public $codeset;
    public $description;
    public $diagnosiscode;
    public $note;
    public $question;
    public $questionid;

    public function rules()
    {
        return [
            [['answer', 'codeset', 'description', 'diagnosiscode', 'note', 'question'], 'trim'],
            [['answer', 'codeset', 'description', 'diagnosiscode', 'note', 'question'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
