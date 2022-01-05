<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property string $userid The id of the user.
 * @property string $access_token Your new Access Token.
 * @property string $refresh_token Your Refresh Token.
 * @property int $expires_in Access token expiry delay in seconds.
 * @property string $scope You can get only the scope that the user accepted with the Token you have. Scopes can be 'user.info' 'user.metrics' 'user.activity' 'user.sleepevents'  and must be separated by a coma.
 * @property string $csrf_token
 * @property string $token_type HTTP Authorization Header format: Bearer
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_bodies}}';
    }

    public function rules()
    {
        return [
            [['userid', 'access_token', 'refresh_token', 'scope', 'csrf_token', 'token_type'], 'trim'],
            [['userid', 'access_token', 'refresh_token', 'scope', 'csrf_token', 'token_type'], 'string'],
            [['expires_in', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($userid = ArrayHelper::getValue($apiObject, 'userid')) {
            $this->userid = $userid;
        }
        if($access_token = ArrayHelper::getValue($apiObject, 'access_token')) {
            $this->access_token = $access_token;
        }
        if($refresh_token = ArrayHelper::getValue($apiObject, 'refresh_token')) {
            $this->refresh_token = $refresh_token;
        }
        if($expires_in = ArrayHelper::getValue($apiObject, 'expires_in')) {
            $this->expires_in = $expires_in;
        }
        if($scope = ArrayHelper::getValue($apiObject, 'scope')) {
            $this->scope = $scope;
        }
        if($csrf_token = ArrayHelper::getValue($apiObject, 'csrf_token')) {
            $this->csrf_token = $csrf_token;
        }
        if($token_type = ArrayHelper::getValue($apiObject, 'token_type')) {
            $this->token_type = $token_type;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
