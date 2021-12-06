<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property array $departmentids For every New/Update Subscriptions complete list of departmentids should be passed. NOTE: Without DepartmentIDs entire Context/Practice will be subscribed.
 * @property string $eventname By default, you are subscribed to all possible events.  If you only wish to subscribe to an individual event, pass the event name with this argument.
 */
class PostLabResultSuscrioptionApi extends BaseApiModel
{

    public $departmentids;
    public $eventname;

    public function rules()
    {
        return [
            [['eventname'], 'trim'],
            [['eventname'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
