<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $clinicaldocumentid The document ID of the new or modified document.
 * @property string $errormessage If the operation failed, this will contain an error message.
 * @property string $success Returns true/false if the operation was successful.
 */
class ClinicalDocument200ResponseApi extends BaseApiModel
{

    public $clinicaldocumentid;
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
