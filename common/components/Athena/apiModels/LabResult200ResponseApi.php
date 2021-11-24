<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property int $labresultid The document ID of the new or modified document.
 * @property string $success Returns true/false if the operation was successful.
 */
class LabResult200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $labresultid;
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
