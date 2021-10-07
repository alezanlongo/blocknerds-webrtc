<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $copayamount The amount of the copay.
 * @property float $copaytype What the copay amount applies to.
 */
class CopaysApi extends BaseApiModel
{

    public $copayamount;
    public $copaytype;

    public function rules()
    {
        return [
            [['copayamount'], 'trim'],
            [['copayamount'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
