<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $startdate The starting datetime for the sleep state data.
 * @property int $enddate The end datetime for the sleep data. A single call can span up to 7 days maximum. To cover a wider time range, you will need to perform multiple calls.
 * @property int $state The state of sleeping. Values can be:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | Sleep state awake|
 * |1 | Sleep state light|
 * |2 | Sleep state deep|
 * |3 | Sleep state rem|
 * |4 | Sleep manual|
 * |5 | Sleep unspecified|
 * @property inline_response_200_16_body_series_hr $hr Heart Rate. *(Use 'data_fields' to request this data.)*
 * @property inline_response_200_16_body_series_rr $rr Respiration Rate. *(Use 'data_fields' to request this data.)*
 * @property inline_response_200_16_body_series_snoring $snoring Total snoring time
 */
class inline_response_200_16_body_seriesApi extends BaseApiModel
{

    public $startdate;
    public $enddate;
    public $state;
    public $hr;
    public $rr;
    public $snoring;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
    }

}
