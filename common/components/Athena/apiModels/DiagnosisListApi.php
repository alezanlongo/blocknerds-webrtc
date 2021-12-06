<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property object $diagnosiscode
 * @property array $snomedicdcodes ICD equivalent Codes for the SNOMED Code
 */
class DiagnosisListApi extends BaseApiModel
{

    public $diagnosiscode;
    public $snomedicdcodes;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
