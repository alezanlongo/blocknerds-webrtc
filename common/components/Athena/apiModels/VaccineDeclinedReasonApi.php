<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $active Indicates whether the declined reason is currently active and may be used for creating new orders
 * @property string $declinedreason The reason that the patient declined the vaccine. Required if the declined date is passed in. Defaults to "Patient decision".
 * @property string $declinedreasonid The declined reason ID.
 */
class VaccineDeclinedReasonApi extends BaseApiModel
{

    public $active;
    public $declinedreason;
    public $declinedreasonid;

    public function rules()
    {
        return [
            [['active', 'declinedreason', 'declinedreasonid'], 'trim'],
            [['active', 'declinedreason', 'declinedreasonid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
