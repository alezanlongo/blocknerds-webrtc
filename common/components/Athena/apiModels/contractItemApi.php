<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $availablebalance The available balance on this contract.
 * @property string $contractclass The type of contract.  For example, "ONEYEAR,"
 * @property string $maxamount The maximum allowed amount for this contract.
 */
class contractItemApi extends Model
{

    public $availablebalance;
    public $contractclass;
    public $maxamount;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

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
