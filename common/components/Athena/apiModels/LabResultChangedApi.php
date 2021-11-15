<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property LabResult[] $labresults list of lab results.
 * @property int $totalcount By default, you are subscribed to all possible events.  If you only wish to subscribe to an individual event, pass the event name with this argument.
 */
class LabResultChangedApi extends BaseApiModel
{

    public $labresults;
 
    protected $_labresultsAr;
    public $totalcount;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->labresults) && is_array($this->labresults)) {
            foreach($this->labresults as $labresults) {
                $this->_labresultsAr[] = new LabResultApi($labresults);
            }
            $this->labresults = $this->_labresultsAr;
            $this->_labresultsAr = [];//CHECKME
        }
    }

}
