<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property float $clinicalorderclassid The clinical order class id
 * @property string $name The name for this clinical order class
 */
class ClinicalOrderClassApi extends BaseApiModel
{

    public $clinicalorderclassid;
    public $name;

    public function rules()
    {
        return [
            [['name'], 'trim'],
            [['name'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
