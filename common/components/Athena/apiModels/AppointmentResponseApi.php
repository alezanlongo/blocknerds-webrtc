<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property object $appointmentids An hash of appointment IDs to the time requested.
 */
class AppointmentResponseApi extends Model
{

    public $appointmentids;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

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
