<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $status Will return one of following statuses: ACTIVE, INACTIVE, or PARTIAL. The PARTIAL status means that not all events are subscribed to. In the event of a problem, UNKNOWN may be returned.
 * @property LabResultSuscription[] $subscriptions List of events you are subscribed to.
 */
class LabResultSuscriptionEventApi extends BaseApiModel
{

    public $status;
    public $subscriptions;
 
    protected $_subscriptionsAr;

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
        if (!empty($this->subscriptions) && is_array($this->subscriptions)) {
            foreach($this->subscriptions as $subscriptions) {
                $this->_subscriptionsAr[] = new LabResultSuscriptionApi($subscriptions);
            }
            $this->subscriptions = $this->_subscriptionsAr;
            $this->_subscriptionsAr = [];//CHECKME
        }
    }

}
