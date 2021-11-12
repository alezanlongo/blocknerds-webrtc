<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code The code indicating why the order was not given.
 * @property string $codeset The codeset that the code belongs to.
 * @property string $description The plaintext description of the reason the order was not given.
 */
class DeclinedReasonApi extends BaseApiModel
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
