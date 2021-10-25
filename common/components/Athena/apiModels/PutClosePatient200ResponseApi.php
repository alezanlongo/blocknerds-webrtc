<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $error String denoting the failure for cse closure.
 * @property string $success Boolean to denote success or failure.
 */
class PutClosePatient200ResponseApi extends BaseApiModel
{

    public $error;
    public $success;

    public function rules()
    {
        return [
            [['error', 'success'], 'trim'],
            [['error', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
