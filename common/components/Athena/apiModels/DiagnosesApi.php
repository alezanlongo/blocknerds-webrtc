<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $description Brief description for this SNOMED Code
 * @property int $diagnosisid Athena ID for this diagnosis
 * @property array $icdcodes List of relevant ICD codes for this diagnosis
 * @property string $note The note entered for this diagnosis.
 * @property int $snomedcode SNOMED Code for this diagnosis
 */
class DiagnosesApi extends BaseApiModel
{

    public $description;
    public $diagnosisid;
    public $icdcodes;
    public $note;
    public $snomedcode;

    public function rules()
    {
        return [
            [['description', 'note'], 'trim'],
            [['description', 'note'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
