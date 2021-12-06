<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property PutAppointment200Response[] $appointments
 * @property int $totalcount
 */
class AppointmentChangedApi extends BaseApiModel
{

    public $appointments;
 
    protected $_appointmentsAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->appointments) && is_array($this->appointments)) {
            foreach($this->appointments as $appointments) {
                $this->_appointmentsAr[] = new PutAppointment200ResponseApi($appointments);
            }
            $this->appointments = $this->_appointmentsAr;
            $this->_appointmentsAr = [];//CHECKME
        }
    }

}
