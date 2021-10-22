<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $assignedto String denoting the entity that the patientcase has been assigned to.
 * @property string $success Boolean to denote success or failure.
 */
class PutReassignPatient200ResponseApi extends BaseApiModel
{

    public $assignedto;
    public $success;

    public function rules()
    {
        return [
            [['assignedto', 'success'], 'trim'],
            [['assignedto', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
