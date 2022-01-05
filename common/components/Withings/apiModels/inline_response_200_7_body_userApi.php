<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code Authorization Code that must be used to retrieve access_token and refresh_token. (Cf. [Token Reception](/developer-guide/logistics-api/authentication#token-reception) section)
 * @property string $external_id Partner end-user unique identifier (Cf. [Token Reception](/developer-guide/logistics-api/authentication#token-reception) section)
 */
class inline_response_200_7_body_userApi extends BaseApiModel
{

    public $code;
    public $external_id;

    public function rules()
    {
        return [
            [['code', 'external_id'], 'trim'],
            [['code', 'external_id'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
