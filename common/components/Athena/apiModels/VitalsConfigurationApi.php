<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $abbreviation Short human-readable string for this vital group. E.g., Ht.
 * @property array $attributes List of vital attributes in this vital group. Contains all possible attributes even if there are no readings.
 * @property string $istiedtomeasurement If true, this vital is tied to some measurement.
 * @property string $key Key for this vital group. E.g., HEIGHT.
 * @property int $ordering Configured order for this vital group
 */
class VitalsConfigurationApi extends BaseApiModel
{

    public $abbreviation;
    public $attributes;
    public $istiedtomeasurement;
    public $key;
    public $ordering;

    public function rules()
    {
        return [
            [['abbreviation', 'istiedtomeasurement', 'key'], 'trim'],
            [['abbreviation', 'istiedtomeasurement', 'key'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
