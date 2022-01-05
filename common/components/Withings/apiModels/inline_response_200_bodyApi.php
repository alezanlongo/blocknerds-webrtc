<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property string $userid The id of the user.
 * @property string $access_token Your new Access Token.
 * @property string $refresh_token Your Refresh Token.
 * @property int $expires_in Access token expiry delay in seconds.
 * @property string $scope You can get only the scope that the user accepted with the Token you have. Scopes can be 'user.info' 'user.metrics' 'user.activity' 'user.sleepevents'  and must be separated by a coma.
 * @property string $csrf_token
 * @property string $token_type HTTP Authorization Header format: Bearer
 */
class inline_response_200_bodyApi extends BaseApiModel
{

    public $userid;
    public $access_token;
    public $refresh_token;
    public $expires_in;
    public $scope;
    public $csrf_token;
    public $token_type;

    public function rules()
    {
        return [
            [['userid', 'access_token', 'refresh_token', 'scope', 'csrf_token', 'token_type'], 'trim'],
            [['userid', 'access_token', 'refresh_token', 'scope', 'csrf_token', 'token_type'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
