<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property string $availablebalance The available balance on this contract.
 * @property string $contractclass The type of contract.  For example, "ONEYEAR,"
 * @property string $maxamount The maximum allowed amount for this contract.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class contractItem extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%contract_items}}';
    }

    public function rules()
    {
        return [
            [['availablebalance', 'contractclass', 'maxamount'], 'trim'],
            [['availablebalance', 'contractclass', 'maxamount'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->availablebalance = ArrayHelper::getValue($obj, 'availablebalance');
        $this->contractclass = ArrayHelper::getValue($obj, 'contractclass');
        $this->maxamount = ArrayHelper::getValue($obj, 'maxamount');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
