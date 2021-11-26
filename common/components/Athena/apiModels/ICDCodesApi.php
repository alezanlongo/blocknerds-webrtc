<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code Actual ICD code for this diagnosis
 * @property string $codeset Codeset for this code (ICD9 or ICD10)
 * @property string $description Brief description for this code
 */
class ICDCodesApi extends BaseApiModel
{

    public $code;
    public $codeset;
    public $description;

    public function rules()
    {
        return [
            [['code', 'codeset', 'description'], 'trim'],
            [['code', 'codeset', 'description'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
