<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $abbreviation Short human-readable string for this vital group. E.g., Ht.
 * @property string $key Key for this vital group. E.g., HEIGHT.
 * @property int $ordering Configured order for this vital group
 * @property Readings[] $readings
 */

class VitalsCustomApi extends VitalsApi
{
    public $abbreviation;
    public $key;
    public $ordering;
    public $readings;

    private $_readingsAr;

    public function init()
    {
        if (!empty($this->readings) && is_array($this->readings)) {
            foreach($this->readings as $readings) {
                foreach($readings as $reading){
                    $this->_readingsAr[] = new ReadingsApi($reading);
                }
            }
            $this->readings = $this->_readingsAr;

            $this->_readingsAr = [];//CHECKME
        }


    }

}
