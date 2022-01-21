<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Code generator needs a class to be able to process API response, you can indicate a custom class to be returned by the method.
 * When the response is an empty body we need to use an empty class as a workaround or it will fail.
 */

class emptyApi extends BaseApiModel
{

    public function rules()
    {
        return [];
    }
    public function init()
    {
        parent::init();
    }
}
