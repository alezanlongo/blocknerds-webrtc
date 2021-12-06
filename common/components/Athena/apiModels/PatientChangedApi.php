<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Patient[] $patients
 * @property int $totalcount
 */
class PatientChangedApi extends BaseApiModel
{

    public $patients;
 
    protected $_patientsAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->patients) && is_array($this->patients)) {
            foreach($this->patients as $patients) {
                $this->_patientsAr[] = new PatientApi($patients);
            }
            $this->patients = $this->_patientsAr;
            $this->_patientsAr = [];//CHECKME
        }
    }

}
