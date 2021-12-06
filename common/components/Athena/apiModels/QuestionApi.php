<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $answer The answer
 * @property string $question The question
 */
class QuestionApi extends BaseApiModel
{

    public $answer;
    public $question;

    public function rules()
    {
        return [
            [['answer', 'question'], 'trim'],
            [['answer', 'question'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
