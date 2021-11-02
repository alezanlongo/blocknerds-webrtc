<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $departmentid The department ID; needed because charts, and thus chart notes, may be department-specific
 * @property string $notetext The note text.  Use PUT to add to any existing text and POST if you want to add new or replace the full note
 */
class RequestChartAlertApi extends BaseApiModel
{

    public $departmentid;
    public $notetext;

    public function rules()
    {
        return [
            [['notetext'], 'trim'],
            [['departmentid', 'notetext'], 'required'],
            [['notetext'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
