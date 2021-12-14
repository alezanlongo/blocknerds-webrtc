<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $checkboxesconfigured The number of checkboxes the practice has configured.
 * @property object $insuredsignature
 * @property object $patientsignature
 * @property object $privacynotice
 */
class PrivacyInformationVerifiedApi extends BaseApiModel
{

    public $checkboxesconfigured;
    public $insuredsignature;
    public $patientsignature;
    public $privacynotice;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
