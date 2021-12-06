<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $image Base64 encoded image.
 * @property int $insuranceid The athena ID of the insurance
 * @property PatientInsurance $patientInsurance
 */
class InsuranceCardImageApi extends BaseApiModel
{

    public $image;
    public $insuranceid;
    public $patientInsurance;

    public function rules()
    {
        return [
            [['image'], 'trim'],
            [['image'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
