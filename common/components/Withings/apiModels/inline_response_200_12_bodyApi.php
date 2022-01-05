<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property activity_object[] $activities
 * @property bool $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 */
class inline_response_200_12_bodyApi extends BaseApiModel
{

    public $activities;
 
    protected $_activitiesAr;
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
        if (!empty($this->activities) && is_array($this->activities)) {
            foreach($this->activities as $activities) {
                $this->_activitiesAr[] = new activity_objectApi($activities);
            }
            $this->activities = $this->_activitiesAr;
            $this->_activitiesAr = [];//CHECKME
        }
    }

}
