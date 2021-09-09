<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property array $addresslist The addresses associated with this insurance package. The default address is listed first.
 * @property array $affiliations The affiliations associated with this insurance package.
 * @property int $insurancepackageid The athena insurance package ID.
 * @property string $insuranceplanname Name of the specific insurance package.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class insurancePackages extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%insurance_packages}}';
    }

    public function rules()
    {
        return [
            [['insuranceplanname'], 'trim'],
            [['insuranceplanname'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->addresslist = ArrayHelper::getValue($obj, 'addresslist');
        $this->affiliations = ArrayHelper::getValue($obj, 'affiliations');
        $this->insurancepackageid = ArrayHelper::getValue($obj, 'insurancepackageid');
        $this->insuranceplanname = ArrayHelper::getValue($obj, 'insuranceplanname');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
