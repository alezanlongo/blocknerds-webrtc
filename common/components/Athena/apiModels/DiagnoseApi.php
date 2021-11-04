<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code Diagnosis code
 * @property string $codeset Diagnosis codeset (SNOMED, ICD9, ICD10, etc)
 * @property string $name Diagnosis name. Might be different than problem name.
 */
class DiagnoseApi extends BaseApiModel
{

    public $code;
    public $codeset;
    public $name;

    public function rules()
    {
        return [
            [['code', 'codeset', 'name'], 'trim'],
            [['code', 'codeset', 'name'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
