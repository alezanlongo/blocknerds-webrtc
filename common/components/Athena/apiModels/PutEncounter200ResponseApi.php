<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $success Whether the operation was successful.
 */
class PutEncounter200ResponseApi extends Model
{

    public $errormessage;
    public $success;

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
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
