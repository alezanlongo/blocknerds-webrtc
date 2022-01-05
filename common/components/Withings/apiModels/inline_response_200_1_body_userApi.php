<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code Authorization Code that must be used to retrieve access_token and refresh_token. (Cf. [Token Reception](/developer-guide/logistics-api/authentication#token-reception) section)
 */
class inline_response_200_1_body_userApi extends BaseApiModel
{

    public $code;

    public function rules()
    {
        return [
            [['code'], 'trim'],
            [['code'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
