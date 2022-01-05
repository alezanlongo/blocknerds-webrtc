<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property inline_response_200_7_body_user $user
 * @property user_device_mac_object[] $devices
 */
class inline_response_200_18_bodyApi extends BaseApiModel
{

    public $user;
    public $devices;
 
    protected $_devicesAr;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->devices) && is_array($this->devices)) {
            foreach($this->devices as $devices) {
                $this->_devicesAr[] = new user_device_mac_objectApi($devices);
            }
            $this->devices = $this->_devicesAr;
            $this->_devicesAr = [];//CHECKME
        }
    }

}
