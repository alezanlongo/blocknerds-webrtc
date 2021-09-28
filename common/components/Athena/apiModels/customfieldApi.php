<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $customfieldid Corresponds to the /customfields customfieldid.
 * @property string $customfieldvalue For a non-select custom field, the value.
 * @property string $optionid For a select custom field, the selectid value (from /customfield's selectlist).
 * @property Patient $patient
 */
class customfieldApi extends Model
{

    public $customfieldid;
    public $customfieldvalue;
    public $optionid;
    public $patient;

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
            [['customfieldid', 'customfieldvalue', 'optionid'], 'trim'],
            [['customfieldid', 'customfieldvalue', 'optionid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
