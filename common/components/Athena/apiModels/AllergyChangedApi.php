<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Allergy[] $medications
 * @property int $totalcount
 */
class AllergyChangedApi extends BaseApiModel
{

    public $medications;
 
    protected $_medicationsAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->medications) && is_array($this->medications)) {
            foreach($this->medications as $medications) {
                $this->_medicationsAr[] = new AllergyApi($medications);
            }
            $this->medications = $this->_medicationsAr;
            $this->_medicationsAr = [];//CHECKME
        }
    }

}
