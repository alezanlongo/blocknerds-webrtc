<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property array $icd10codes ICD-10 code(s) for this diagnosis.
 * @property array $icd9codes ICD-9 code(s) for this diagnosis.
 * @property string $laterality Laterality of the SNOMED code.
 * @property string $note The note to be entered for this diagnosis.
 * @property int $snomedcode SNOMED code for this diagnosis.
 */
class RequestCreateDiagnosisApi extends BaseApiModel
{

    public $icd10codes;
    public $icd9codes;
    public $laterality;
    public $note;
    public $snomedcode;

    public function rules()
    {
        return [
            [['laterality', 'note'], 'trim'],
            [['snomedcode'], 'required'],
            [['laterality', 'note'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
