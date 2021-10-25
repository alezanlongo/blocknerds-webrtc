<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $actionreasonid Valid Document Action Reason ID for closure of Patient Case.
 */
class RequestClosePatientCaseApi extends BaseApiModel
{

    public $actionreasonid;

    public function rules()
    {
        return [
            [['actionreasonid'], 'required'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
