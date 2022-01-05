<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property heart_measurement_object[] $series
 * @property bool $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 */
class inline_response_200_11_bodyApi extends BaseApiModel
{

    public $series;
 
    protected $_seriesAr;
    public $more;
    public $offset;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->series) && is_array($this->series)) {
            foreach($this->series as $series) {
                $this->_seriesAr[] = new heart_measurement_objectApi($series);
            }
            $this->series = $this->_seriesAr;
            $this->_seriesAr = [];//CHECKME
        }
    }

}
