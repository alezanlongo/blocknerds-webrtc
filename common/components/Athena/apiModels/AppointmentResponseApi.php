<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property object $appointmentids An hash of appointment IDs to the time requested.
 */
class AppointmentResponseApi extends BaseApiModel
{

    public $appointmentids;

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
