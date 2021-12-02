<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
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
 */
class TopInsurancePackagesApi extends BaseApiModel
{

    public $address;
    public $address2;
    public $city;
    public $insurancepackageid;
    public $insuranceproducttypename;
    public $name;
    public $percentage;
    public $phone;
    public $ranking;
    public $state;
    public $zip;

    public function rules()
    {
        return [
            [['address', 'address2', 'city', 'insurancepackageid', 'insuranceproducttypename', 'name', 'percentage', 'phone', 'ranking', 'state', 'zip'], 'trim'],
            [['address', 'address2', 'city', 'insurancepackageid', 'insuranceproducttypename', 'name', 'percentage', 'phone', 'ranking', 'state', 'zip'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
