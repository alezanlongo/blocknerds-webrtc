<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property string $nonce A random timestamp based token to be used once in requiring signature API services to avoid replay attack
 */
class inline_response_200_15_bodyApi extends BaseApiModel
{

    public $nonce;

    public function rules()
    {
        return [
            [['nonce'], 'trim'],
            [['nonce'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
