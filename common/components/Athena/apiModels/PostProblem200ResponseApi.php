<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage Error message will be returned if show error message flag is set to true and patient match found.
 * @property string $problemid Please remember to never disclose this ID to patients since it may result in inadvertant disclosure that a patient exists in a practice already.
 * @property string $success
 */
class PostProblem200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $problemid;
    public $success;

    public function rules()
    {
        return [
            [['errormessage', 'problemid', 'success'], 'trim'],
            [['errormessage', 'problemid', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
