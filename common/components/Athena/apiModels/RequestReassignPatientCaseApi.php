<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $username AthenNet user to whom the case is being reassigned to.This parameter is case-sensitive.
 */
class RequestReassignPatientCaseApi extends BaseApiModel
{

    public $username;

    public function rules()
    {
        return [
            [['username'], 'trim'],
            [['username'], 'required'],
            [['username'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
