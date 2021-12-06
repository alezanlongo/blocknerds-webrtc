<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $reason Human readable string for the reason.
 * @property int $reasonid ID of the reason.
 */
class CloseReasonApi extends BaseApiModel
{

    public $reason;
    public $reasonid;

    public function rules()
    {
        return [
            [['reason'], 'trim'],
            [['reason'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
