<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $actionnote The action notes that are attached to the document.
 * @property string $assignedto This field will describe who was assigned this document during this document action.
 * @property string $createdby The username of the person that created this document action.
 * @property string $createddatetime The datetime this action note was created.
 * @property int $patientid The patient ID this document is tied to.
 * @property int $priority Priority given for this document action.
 * @property string $status Status given for this document action.
 */
class ActionNoteApi extends BaseApiModel
{

    public $actionnote;
    public $assignedto;
    public $createdby;
    public $createddatetime;
    public $patientid;
    public $priority;
    public $status;

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createdby', 'createddatetime', 'status'], 'trim'],
            [['actionnote', 'assignedto', 'createdby', 'createddatetime', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
