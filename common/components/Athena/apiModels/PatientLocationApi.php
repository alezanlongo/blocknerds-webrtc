<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $defaultoncheckin Whether this is the default location once the appointment is checked in and the encounter is created
 * @property string $name Name of this location
 * @property int $patientlocationid Athena patient location ID
 */
class PatientLocationApi extends Model
{

    public $defaultoncheckin;
    public $name;
    public $patientlocationid;

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
            [['defaultoncheckin', 'name'], 'trim'],
            [['defaultoncheckin', 'name'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
