<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $balance Balance for this provider group.
 * @property string $cleanbalance Indicates whether the balance is associated with a contract, payment plan, or collections agency.
 * @property string $collectionsbalance The outstanding amount associated with a collections agency.
 * @property contractItem[] $contracts Information related to existing credit card contracts.
 * @property string $departmentids Comma separated list of department IDs that belong to this group
 * @property string $paymentplanbalance The outstanding amount associated with a payment plan.
 * @property int $providergroupid Athena ID for this financial group.
 */
class BalanceItemApi extends Model
{

    public $balance;
    public $cleanbalance;
    public $collectionsbalance;
    public $contracts;
 
    protected $_contractsAr;
    public $departmentids;
    public $paymentplanbalance;
    public $providergroupid;

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
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'trim'],
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->contracts) && is_array($this->contracts)) {
            $this->_contractsAr = $this->contracts;
            $this->contracts = new contractItemApi($this->_contractsAr);
        }
    }

}
