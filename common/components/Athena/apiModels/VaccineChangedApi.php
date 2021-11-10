<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Vaccine[] $vaccines
 * @property int $totalcount
 */
class VaccineChangedApi extends BaseApiModel
{

    public $vaccines;
 
    protected $_vaccinesAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->vaccines) && is_array($this->vaccines)) {
            foreach($this->vaccines as $vaccines) {
                $this->_vaccinesAr[] = new VaccineApi($vaccines);
            }
            $this->vaccines = $this->_vaccinesAr;
            $this->_vaccinesAr = [];//CHECKME
        }
    }

}
