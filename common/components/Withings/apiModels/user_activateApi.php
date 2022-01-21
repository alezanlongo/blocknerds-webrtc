<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property dropshipment_user $user
 * @property user_device_mac_object[] $devices
 */
class user_activateApi extends BaseApiModel
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
