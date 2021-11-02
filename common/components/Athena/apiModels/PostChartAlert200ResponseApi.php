<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $success Returns true/false if the operation was successful
 */
class PostChartAlert200ResponseApi extends BaseApiModel
{

    public $success;

    public function rules()
    {
        return [
            [['success'], 'trim'],
            [['success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
