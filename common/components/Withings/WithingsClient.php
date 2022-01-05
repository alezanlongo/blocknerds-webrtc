<?php

namespace common\components\Withings;

use Yii;
use yii\base\Model;


class WithingsClient extends \common\components\Withings\WithingsOauth 
{
    /**
     * @return inline_response_200
     */
    public function oauth2-getaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200
     */
    public function oauth2-refreshaccesstoken(array $body = [])
    {
        $path = trim('/v2/oauth2  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_1
     */
    public function oauth2-recoverauthorizationcode(array $body = [])
    {
        $path = trim('/v2/oauth2 ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_1Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_2
     */
    public function measure-getmeas(array $body = [])
    {
        $path = trim('/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_2Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_3
     */
    public function notify-get(array $body = [])
    {
        $path = trim('/notify ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_3Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_4
     */
    public function notify-list(array $body = [])
    {
        $path = trim('/notify  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_4Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notify-revoke(array $body = [])
    {
        $path = trim('/notify    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notify-subscribe(array $body = [])
    {
        $path = trim('/notify');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function notify-update(array $body = [])
    {
        $path = trim('/notify   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_6
     */
    public function dropshipmentv2-createorder(array $body = [])
    {
        $path = trim('/v2/dropshipment');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_6Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_7
     */
    public function dropshipmentv2-createuserorder(array $body = [])
    {
        $path = trim('/v2/dropshipment ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_7Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function dropshipmentv2-delete(array $body = [])
    {
        $path = trim('/v2/dropshipment   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_8
     */
    public function dropshipmentv2-getorderstatus(array $body = [])
    {
        $path = trim('/v2/dropshipment  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_8Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_9
     */
    public function dropshipmentv2-update(array $body = [])
    {
        $path = trim('/v2/dropshipment    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_9Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_10
     */
    public function heartv2-get(array $body = [])
    {
        $path = trim('/v2/heart ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_10Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_11
     */
    public function heartv2-list(array $body = [])
    {
        $path = trim('/v2/heart');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_11Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_12
     */
    public function measurev2-getactivity(array $body = [])
    {
        $path = trim('/v2/measure');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_12Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_13
     */
    public function measurev2-getintradayactivity(array $body = [])
    {
        $path = trim('/v2/measure  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_13Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_14
     */
    public function measurev2-getworkouts(array $body = [])
    {
        $path = trim('/v2/measure ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_14Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_15
     */
    public function signaturev2-getnonce(array $body = [])
    {
        $path = trim('/v2/signature');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_15Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_16
     */
    public function sleepv2-get(array $body = [])
    {
        $path = trim('/v2/sleep');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_16Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_17
     */
    public function sleepv2-getsummary(array $body = [])
    {
        $path = trim('/v2/sleep ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_17Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_18
     */
    public function userv2-activate(array $body = [])
    {
        $path = trim('/v2/user ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_18Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_19
     */
    public function userv2-get(array $body = [])
    {
        $path = trim('/v2/user');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_19Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_20
     */
    public function userv2-getdevice(array $body = [])
    {
        $path = trim('/v2/user   ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_20Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_21
     */
    public function userv2-getgoals(array $body = [])
    {
        $path = trim('/v2/user     ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_21Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_22
     */
    public function userv2-link(array $body = [])
    {
        $path = trim('/v2/user  ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_22Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
    /**
     * @return inline_response_200_5
     */
    public function userv2-unlink(array $body = [])
    {
        $path = trim('/v2/user    ');

        $dataResponse = $this->callMethod($path, 'post' , $body);
        if($dataResponse['success']){
            return new \common\components\Withings\apiModels\inline_response_200_5Api($dataResponse['data']);
        }else{
            return $dataResponse['message'];
        }
    }
}
