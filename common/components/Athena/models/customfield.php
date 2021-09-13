<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property string $customfieldid Corresponds to the /customfields customfieldid.
 * @property string $customfieldvalue For a non-select custom field, the value.
 * @property string $optionid For a select custom field, the selectid value (from /customfield's selectlist).
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class customfield extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%customfields}}';
    }

    public function rules()
    {
        return [
            [['customfieldid', 'customfieldvalue', 'optionid'], 'trim'],
            [['customfieldid', 'customfieldvalue', 'optionid'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->customfieldid = ArrayHelper::getValue($obj, 'customfieldid');
        $this->customfieldvalue = ArrayHelper::getValue($obj, 'customfieldvalue');
        $this->optionid = ArrayHelper::getValue($obj, 'optionid');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
