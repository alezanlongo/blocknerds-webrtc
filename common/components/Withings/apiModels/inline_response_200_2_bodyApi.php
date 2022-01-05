<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property string $updatetime Server time at which the answer was generated.
 * @property string $timezone Timezone for the date.
 * @property measuregrp_object[] $measuregrps Measures are returned in groups.
 * @property int $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 */
class inline_response_200_2_bodyApi extends BaseApiModel
{

    public $updatetime;
    public $timezone;
    public $measuregrps;
 
    protected $_measuregrpsAr;
    public $more;
    public $offset;

    public function rules()
    {
        return [
            [['updatetime', 'timezone'], 'trim'],
            [['updatetime', 'timezone'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->measuregrps) && is_array($this->measuregrps)) {
            foreach($this->measuregrps as $measuregrps) {
                $this->_measuregrpsAr[] = new measuregrp_objectApi($measuregrps);
            }
            $this->measuregrps = $this->_measuregrpsAr;
            $this->_measuregrpsAr = [];//CHECKME
        }
    }

}
