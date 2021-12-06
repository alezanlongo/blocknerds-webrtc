<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Problem[] $problems
 * @property int $totalcount
 */
class ProblemChangedApi extends BaseApiModel
{

    public $problems;
 
    protected $_problemsAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->problems) && is_array($this->problems)) {
            foreach($this->problems as $problems) {
                $this->_problemsAr[] = new ProblemApi($problems);
            }
            $this->problems = $this->_problemsAr;
            $this->_problemsAr = [];//CHECKME
        }
    }

}
