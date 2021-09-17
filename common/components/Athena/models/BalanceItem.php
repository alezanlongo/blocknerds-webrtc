<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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

        $this->balance = ArrayHelper::getValue($apiObject, 'balance');
        $this->cleanbalance = ArrayHelper::getValue($apiObject, 'cleanbalance');
        $this->collectionsbalance = ArrayHelper::getValue($apiObject, 'collectionsbalance');
        $this->contracts = ArrayHelper::getValue($apiObject, 'contracts');
        $this->departmentids = ArrayHelper::getValue($apiObject, 'departmentids');
        $this->paymentplanbalance = ArrayHelper::getValue($apiObject, 'paymentplanbalance');
        $this->providergroupid = ArrayHelper::getValue($apiObject, 'providergroupid');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
