<?php

namespace common\components\Withings;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\db\Exception as DBException;
use yii\httpclient\Client;
use yii\httpclient\Exception as HttpClientException;

use common\models\Configuration;
use common\models\UserSetting;
use yii\helpers\VarDumper;
use yii\web\UnprocessableEntityHttpException;

class WithingsOauth
{
    public $clientId;
    public $customerSecret;

    private $responseDataKey;
    private $responseMessageKey;

    const CONFIGURATION_TYPE = "WithingsToken";
    const RESPONSE_TYPE_CODE = "code";
    const REQUEST_TYPE_ACTION = "requesttoken";
    const GRANT_TYPE_AUTH_CODE = "authorization_code";
    const GRANT_TYPE_REF_TOKEN = "refresh_token";
    const SCOPE_USER_ACTIVITY = "user.activity";
    const SCOPE_USER_METRICS = "user.metrics";
    const SCOPE_USER_INFO = "user.info";
    const SCOPE_DEVICE_INFO = "device.info";
    const SCOPE_DEVICE_ENVIRONMENT = "device.environment";

    public function __construct()
    {
        $this->clientId = Yii::$app->params['withings.clientId'];
        $this->customerSecret = Yii::$app->params['withings.consumerSecret'];
        $this->responseDataKey = 'body';
        $this->responseMessageKey = 'error';
    }

    public function getResponseDataKey()
    {
        return $this->responseDataKey;
    }

    public function getResponseMessageKey()
    {
        return $this->responseMessageKey;
    }

    public function isSuccess($dataResponse)
    {
        if (!isset($dataResponse['status']) || intval($dataResponse['status']) !== 0) {
            return false;
        }
        return true;
    }

    public function getAuthenticationCode()
    {
        $state = "webartc";
        $scopes = self::SCOPE_USER_INFO . ',' . self::SCOPE_USER_METRICS . ',' . self::SCOPE_USER_ACTIVITY . ',' . self::SCOPE_DEVICE_INFO . ',' . self::SCOPE_DEVICE_ENVIRONMENT;

        $params = [
            'response_type' => self::RESPONSE_TYPE_CODE,
            'client_id' => $this->clientId,
            'state' => $state,
            'scope' => $scopes,
            'redirect_uri' => Yii::$app->params['withings.redirect_uri'],
        ];

        $path = "oauth2_user/authorize2";
        $url = 'https://account.withings.com/' . $path . '?' . http_build_query($params);

        return $url;
    }

    public function requestToken(string $code = null)
    {
        $params = [
            'action' => self::REQUEST_TYPE_ACTION,
            'grant_type' => self::GRANT_TYPE_AUTH_CODE,
            'client_id' => $this->clientId,
            'client_secret' => $this->customerSecret,
            'code' => $code,
            'redirect_uri' => Yii::$app->params['withings.redirect_uri'],
        ];

        $path = "v2/oauth2";
        $client = new Client(['baseUrl' =>  Yii::$app->params['withings.api_url']]);

        $response = $client->post($path, $params)->send();

        if (!$response->isOk) {
            throw new UnprocessableEntityHttpException("Unprocessable Entity.");
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $dataResponse = json_decode($response->getContent(), TRUE);

        if ($dataResponse['status'] != 0) {
            throw new \yii\web\BadRequestHttpException($dataResponse['error'], $dataResponse['status']);
        }

        $configurationModel = Configuration::find()->where([
            'type'          => self::CONFIGURATION_TYPE,
            'practiceId'    => $dataResponse['body']['userid']
        ])->one();

        if (!is_null($configurationModel)) {
            $configurationModel->content = json_encode($dataResponse);
            $configurationModel->save();
        } else {
            $configurationModel = new Configuration;
            $configurationModel->type = self::CONFIGURATION_TYPE;
            $configurationModel->content = json_encode($dataResponse);
            $configurationModel->practiceId = $dataResponse['body']['userid'];
            $configurationModel->save();

            UserSetting::setValue(
                Yii::$app->user->identity->id,
                'userid',
                UserSetting::GROUP_NAME_WITHINGS,
                $dataResponse['body']['userid']
            );
        }

        return json_decode($configurationModel->content);
    }

    public function requestRefreshToken()
    {
        // $nonce = $this->getNonce();

        $user = Yii::$app->user->identity;

        $configurationModel = $this->getUserConfiguration($user->id);
        $withingsConfiguration = json_decode($configurationModel->content);

        $params = [
            'action' => self::REQUEST_TYPE_ACTION,
            'grant_type' => self::GRANT_TYPE_REF_TOKEN,
            'client_id' => $this->clientId,
            'client_secret' => $this->customerSecret,
            'refresh_token' => $withingsConfiguration->body->refresh_token
        ];

        $path = "v2/oauth2";
        $client = new Client(['baseUrl' =>  Yii::$app->params['withings.api_url']]);

        $response = $client->post($path, $params)->send();

        if (!$response->isOk) {
            throw new UnprocessableEntityHttpException("Unprocessable Entity.");
        }

        $dataResponse = json_decode($response->getContent(), TRUE);

        if ($dataResponse['status'] != 0) {
            throw new \yii\web\BadRequestHttpException($dataResponse['error'], $dataResponse['status']);
        }

        $configurationModel->content = json_encode($dataResponse);
        $configurationModel->save();

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return json_decode($configurationModel->content);
    }

    public function callSignedMethod()
    {
        throw new UnprocessableEntityHttpException("Unprocessable Entity, method pending of implementation.");
    }

    public function callMethod($path, $action, array $params = [])
    {
        $user = Yii::$app->user->identity;

        $configurationModel = $this->getUserConfiguration($user->id);
        $withingsConfiguration = json_decode($configurationModel->content);

        $link = Yii::$app->params['withings.api_url'] . $path;

        $link = str_replace("//", "/", $link);

        $client = new Client(['baseUrl' =>  Yii::$app->params['withings.api_url']]);

        $response = $this->createRequest($client, $link, $action, $withingsConfiguration->body->access_token, $params);

        $dataResponse = json_decode($response->getContent(), TRUE);

        if ($response->isOk) {
            if (in_array($dataResponse['status'], [100, 101, 102, 200, 401])) {
                $refreshToken = $this->requestRefreshToken();

                $response = $this->createRequest($client, $link, $action, $refreshToken->body->access_token, $params);

                $dataResponse = json_decode($response, TRUE);
            }

            $error = '';
            if (isset($dataResponse['error'])) {
                $error = $dataResponse['error'] . ' (' . $dataResponse['status'] . ')';
                throw new \yii\web\BadRequestHttpException($error);
            }
        } else {
            throw new \yii\web\BadRequestHttpException();
        }

        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        return $dataResponse;
    }

    private function createRequest($client, $link, $action, $access_token, $params)
    {
        $request = $client->createRequest()
            ->setUrl($link)
            ->setMethod(strtoupper(trim($action)))
            ->setHeaders([
                'Authorization' => 'Bearer ' . $access_token,
            ])
            ->setData($params);

        try {
            $response = $request->send();
        } catch (\Exception $e) {
            throw new \yii\web\BadRequestHttpException();
        }

        return $response;
    }

    private function getUserConfiguration($user_id)
    {
        $withingsUserId = UserSetting::getSetting($user_id, 'userid', UserSetting::GROUP_NAME_WITHINGS);

        if (is_null($withingsUserId)) {
            throw new UnprocessableEntityHttpException("Unprocessable Entity, Withings user id does not exist in our database.");
        }

        $configurationModel = Configuration::find()->where([
            'type'          => self::CONFIGURATION_TYPE,
            'practiceId'    => $withingsUserId->value
        ])->one();

        if (is_null($configurationModel)) {
            throw new UnprocessableEntityHttpException("Unprocessable Entity, Withings user configuration does not exist in our database.");
        }

        return $configurationModel;
    }

    private function getNonce()
    {
        $action = 'getnonce';
        $time = time();
        $signature = $this->buildSignature($action, $time);
        $params = [
            'action' => $action,
            'client_id' => $this->clientId,
            'timestamp' => $time,
            'signature' => $signature,
        ];

        $path = "v2/signature";
        $client = new Client(['baseUrl' =>  Yii::$app->params['withings.api_url']]);

        $response = $client->post($path, $params)->send();

        if (!$response->isOk) {
            throw new UnprocessableEntityHttpException("Unprocessable Entity");
        }

        $dataResponse = json_decode($response->getContent(), TRUE);

        if ($dataResponse['status'] != 0) {
            throw new \yii\web\BadRequestHttpException($dataResponse['error'], $dataResponse['status']);
        }

        return $dataResponse['body']['nonce'];
    }

    private function buildSignature(string $action, int $time)
    {
        $signed_params = array(
            'action'     => $action,
            'client_id'  => $this->clientId,
            'timestamp'      => $time,
        );

        ksort($signed_params);

        $data = implode(",", $signed_params);

        return hash_hmac('sha256', $data, $this->customerSecret);
    }
}
