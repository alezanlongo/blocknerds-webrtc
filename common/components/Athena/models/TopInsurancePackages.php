<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $address The first address line associated with this insurance package, often on the insurance card itself as a place to send claims.
 * @property string $address2 The second address line associated with this insurance package.
 * @property string $city The city associated with this insurance package.
 * @property string $insurancepackageid The athenaNet-wide insurance package (also know in the industry as an "insurance product") id.
 * @property string $insuranceproducttypename The type of product (e.g. PPO, HMO, etc.)
 * @property string $name The name of the insurance package.
 * @property string $percentage The percentage of insurance packages in this practice (or department, if a departmentid is specified in the input) that use this insurance package.
 * @property string $phone The phone number associated with this insurance package.
 * @property string $ranking The ranking of how often this package is used by this practice (or department, if a departmentid is specified in the input).
 * @property string $state The state associated with this insurance package.
 * @property string $zip The zip code associated with this insurance package.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class TopInsurancePackages extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%top_insurance_packages}}';
    }

    public function rules()
    {
        return [
            [['address', 'address2', 'city', 'insurancepackageid', 'insuranceproducttypename', 'name', 'percentage', 'phone', 'ranking', 'state', 'zip'], 'trim'],
            [['address', 'address2', 'city', 'insurancepackageid', 'insuranceproducttypename', 'name', 'percentage', 'phone', 'ranking', 'state', 'zip'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($address = ArrayHelper::getValue($apiObject, 'address')) {
            $this->address = $address;
        }
        if($address2 = ArrayHelper::getValue($apiObject, 'address2')) {
            $this->address2 = $address2;
        }
        if($city = ArrayHelper::getValue($apiObject, 'city')) {
            $this->city = $city;
        }
        if($insurancepackageid = ArrayHelper::getValue($apiObject, 'insurancepackageid')) {
            $this->insurancepackageid = $insurancepackageid;
        }
        if($insuranceproducttypename = ArrayHelper::getValue($apiObject, 'insuranceproducttypename')) {
            $this->insuranceproducttypename = $insuranceproducttypename;
        }
        if($name = ArrayHelper::getValue($apiObject, 'name')) {
            $this->name = $name;
        }
        if($percentage = ArrayHelper::getValue($apiObject, 'percentage')) {
            $this->percentage = $percentage;
        }
        if($phone = ArrayHelper::getValue($apiObject, 'phone')) {
            $this->phone = $phone;
        }
        if($ranking = ArrayHelper::getValue($apiObject, 'ranking')) {
            $this->ranking = $ranking;
        }
        if($state = ArrayHelper::getValue($apiObject, 'state')) {
            $this->state = $state;
        }
        if($zip = ArrayHelper::getValue($apiObject, 'zip')) {
            $this->zip = $zip;
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

        return $saved;
    }
    */
}
