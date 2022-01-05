<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $id Id of the user
 * @property int $measure Most recent modified date of user measures
 */
class lastupdate_objectApi extends BaseApiModel
{

    public $id;
    public $measure;

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
