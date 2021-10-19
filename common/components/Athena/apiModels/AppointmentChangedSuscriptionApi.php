<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $status Will return one of following statuses: ACTIVE, INACTIVE, or PARTIAL. The PARTIAL status means that not all events are subscribed to. In the event of a problem, UNKNOWN may be returned.
 * @property array $subscriptions List of events you are subscribed to.
 */
class AppointmentChangedSuscriptionApi extends BaseApiModel
{

    public $status;
    public $subscriptions;

    public function rules()
    {
        return [
            [['status'], 'trim'],
            [['status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
