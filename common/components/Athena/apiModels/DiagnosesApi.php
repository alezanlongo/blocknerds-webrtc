<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $description Brief description for this SNOMED Code
 * @property int $diagnosisid Athena ID for this diagnosis
 * @property array $icdcodes List of relevant ICD codes for this diagnosis
 * @property string $note The note entered for this diagnosis.
 * @property int $snomedcode SNOMED Code for this diagnosis
 */
class DiagnosesApi extends Model
{

    public $description;
    public $diagnosisid;
    public $icdcodes;
    public $note;
    public $snomedcode;

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
            [['description', 'note'], 'trim'],
            [['description', 'note'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
