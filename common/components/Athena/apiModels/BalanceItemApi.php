<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

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
 * @property Patient $patient
 */
class BalanceItemApi extends BaseApiModel
{

    public $balance;
    public $cleanbalance;
    public $collectionsbalance;
    public $contracts;
 
    protected $_contractsAr;
    public $departmentids;
    public $paymentplanbalance;
    public $providergroupid;
    public $patient;

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
            foreach($this->contracts as $contracts) {
                $this->_contractsAr[] = new contractItemApi($contracts);
            }
            $this->contracts = $this->_contractsAr;
            $this->_contractsAr = [];//CHECKME
        }
    }

}
