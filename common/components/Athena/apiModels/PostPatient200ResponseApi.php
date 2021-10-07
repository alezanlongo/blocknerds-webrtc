<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage Error message will be returned if show error message flag is set to true and patient match found.
 * @property string $patientid Please remember to never disclose this ID to patients since it may result in inadvertant disclosure that a patient exists in a practice already.
 */
class PostPatient200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $patientid;

    public function rules()
    {
        return [
            [['errormessage', 'patientid'], 'trim'],
            [['errormessage', 'patientid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
