<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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

        if($addresslist = ArrayHelper::getValue($apiObject, 'addresslist')) {
            $this->addresslist = $addresslist;
        }
        if($affiliations = ArrayHelper::getValue($apiObject, 'affiliations')) {
            $this->affiliations = $affiliations;
        }
        if($insurancepackageid = ArrayHelper::getValue($apiObject, 'insurancepackageid')) {
            $this->insurancepackageid = $insurancepackageid;
        }
        if($insuranceplanname = ArrayHelper::getValue($apiObject, 'insuranceplanname')) {
            $this->insuranceplanname = $insuranceplanname;
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
}
