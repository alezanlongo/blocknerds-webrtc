<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property string $copayamount The amount of the copay.
 * @property float $copaytype What the copay amount applies to.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Copays extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%copays}}';
    }

    public function rules()
    {
        return [
            [['copayamount'], 'trim'],
            [['copayamount'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->copayamount = ArrayHelper::getValue($obj, 'copayamount');
        $this->copaytype = ArrayHelper::getValue($obj, 'copaytype');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}