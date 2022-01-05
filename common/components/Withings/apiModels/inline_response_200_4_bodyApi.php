<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property notify_object[] $profiles List of notification configurations for this user.
 */
class inline_response_200_4_bodyApi extends BaseApiModel
{

    public $profiles;
 
    protected $_profilesAr;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->profiles) && is_array($this->profiles)) {
            foreach($this->profiles as $profiles) {
                $this->_profilesAr[] = new notify_objectApi($profiles);
            }
            $this->profiles = $this->_profilesAr;
            $this->_profilesAr = [];//CHECKME
        }
    }

}
