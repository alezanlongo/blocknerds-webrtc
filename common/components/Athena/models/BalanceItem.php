<?php

namespace common\components\Athena\models;

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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class BalanceItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%balance_items}}';
    }

    public function rules()
    {
        return [
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'trim'],
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getContracts()
    {
        return $this->hasMany(contractItem::class, ['balance_item_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->balance = ArrayHelper::getValue($obj, 'balance');
        $this->cleanbalance = ArrayHelper::getValue($obj, 'cleanbalance');
        $this->collectionsbalance = ArrayHelper::getValue($obj, 'collectionsbalance');
        $this->contracts = ArrayHelper::getValue($obj, 'contracts');
        $this->departmentids = ArrayHelper::getValue($obj, 'departmentids');
        $this->paymentplanbalance = ArrayHelper::getValue($obj, 'paymentplanbalance');
        $this->providergroupid = ArrayHelper::getValue($obj, 'providergroupid');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
