<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If not successful, will contain error message.
 * @property string $success True if successful.
 * @property string $supportslaterality If true, then laterality may chosen for the diagnosis.
 */
class PutDiagnosis200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $success;
    public $supportslaterality;

    public function rules()
    {
        return [
            [['errormessage', 'success', 'supportslaterality'], 'trim'],
            [['errormessage', 'success', 'supportslaterality'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
