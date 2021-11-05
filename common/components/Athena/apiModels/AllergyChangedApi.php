<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Allergy[] $allergies
 * @property int $totalcount
 */
class AllergyChangedApi extends BaseApiModel
{

    public $allergies;
 
    protected $_allergiesAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->allergies) && is_array($this->allergies)) {
            foreach($this->allergies as $allergies) {
                $this->_allergiesAr[] = new AllergyApi($allergies);
            }
            $this->allergies = $this->_allergiesAr;
            $this->_allergiesAr = [];//CHECKME
        }
    }

}
