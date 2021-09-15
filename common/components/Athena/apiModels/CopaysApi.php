<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $copayamount The amount of the copay.
 * @property float $copaytype What the copay amount applies to.
 */
class CopaysApi extends Model
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
