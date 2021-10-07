<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $availablebalance The available balance on this contract.
 * @property string $contractclass The type of contract.  For example, "ONEYEAR,"
 * @property string $maxamount The maximum allowed amount for this contract.
 */
class contractItemApi extends BaseApiModel
{

    public $availablebalance;
    public $contractclass;
    public $maxamount;

    public function rules()
    {
        return [
            [['availablebalance', 'contractclass', 'maxamount'], 'trim'],
            [['availablebalance', 'contractclass', 'maxamount'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
