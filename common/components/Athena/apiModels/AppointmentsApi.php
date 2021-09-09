<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property object $appointmentids An hash of appointment IDs to the time requested.
 */
class AppointmentsApi extends Model
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
