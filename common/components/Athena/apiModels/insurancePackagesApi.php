<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property array $addresslist The addresses associated with this insurance package. The default address is listed first.
 * @property array $affiliations The affiliations associated with this insurance package.
 * @property int $insurancepackageid The athena insurance package ID.
 * @property string $insuranceplanname Name of the specific insurance package.
 */
class insurancePackagesApi extends Model
{

    public $addresslist;
    public $affiliations;
    public $insurancepackageid;
    public $insuranceplanname;

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
            [['insuranceplanname'], 'trim'],
            [['insuranceplanname'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
