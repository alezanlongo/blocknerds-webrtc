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
 * @property integer $patient_id
 * @property Patient $patient
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class BalanceItem extends \yii\db\ActiveRecord
{
 
    protected $_contractsAr;

    public static function tableName()
    {
        return '{{%balance_items}}';
    }

    public function rules()
    {
        return [
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'trim'],
            [['balance', 'cleanbalance', 'collectionsbalance', 'departmentids', 'paymentplanbalance'], 'string'],
            [['providergroupid', 'patient_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getContracts()
    {
        return $this->hasMany(contractItem::class, ['balance_item_id' => 'id']);
    }

    public function getPatient()
    {
        return $this->hasOne(Patient::class, ['id' => 'patient_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($balance = ArrayHelper::getValue($apiObject, 'balance')) {
            $this->balance = $balance;
        }
        if($cleanbalance = ArrayHelper::getValue($apiObject, 'cleanbalance')) {
            $this->cleanbalance = $cleanbalance;
        }
        if($collectionsbalance = ArrayHelper::getValue($apiObject, 'collectionsbalance')) {
            $this->collectionsbalance = $collectionsbalance;
        }
        if($contracts = ArrayHelper::getValue($apiObject, 'contracts')) {
            $this->_contractsAr = $contracts;
        }
        if($departmentids = ArrayHelper::getValue($apiObject, 'departmentids')) {
            $this->departmentids = $departmentids;
        }
        if($paymentplanbalance = ArrayHelper::getValue($apiObject, 'paymentplanbalance')) {
            $this->paymentplanbalance = $paymentplanbalance;
        }
        if($providergroupid = ArrayHelper::getValue($apiObject, 'providergroupid')) {
            $this->providergroupid = $providergroupid;
        }
        if($patient_id = ArrayHelper::getValue($apiObject, 'patient_id')) {
            $this->patient_id = $patient_id;
        }
        if($patient = ArrayHelper::getValue($apiObject, 'patient')) {
            $this->patient = $patient;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);
        if( !empty($this->_contractsAr) and is_array($this->_contractsAr) ) {
            foreach($this->_contractsAr as $contractsApi) {
                $contractitem = new contractItem();
                $contractitem->loadApiObject($contractsApi);
                $contractitem->link('balanceItem', $this);
                $contractitem->save();
            }
        }

        return $saved;
    }
    */
}
