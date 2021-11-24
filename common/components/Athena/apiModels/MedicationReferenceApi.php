<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $medication The name of the medication
 * @property int $medicationid The athena ID of the medication
 */
class MedicationReferenceApi extends BaseApiModel
{

    public $medication;
    public $medicationid;

    public function rules()
    {
        return [
            [['medication'], 'trim'],
            [['medication'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
