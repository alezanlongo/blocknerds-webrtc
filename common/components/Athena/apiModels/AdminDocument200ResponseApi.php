<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $adminid The document ID of the new or modified document.
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property string $success Returns true/false if the operation was successful.
 */
class AdminDocument200ResponseApi extends BaseApiModel
{

    public $adminid;
    public $errormessage;
    public $success;

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
