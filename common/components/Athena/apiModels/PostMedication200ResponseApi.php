<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $medicationentryid If successful, the athena ID of the newly created historical medication
 * @property string $success Whether the operation was successful or not.
 */
class PostMedication200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $medicationentryid;
    public $success;

    public function rules()
    {
        return [
            [['errormessage', 'medicationentryid', 'success'], 'trim'],
            [['errormessage', 'medicationentryid', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
