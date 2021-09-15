<?php
namespace common\components\Athena;

use common\components\Athena\apiModels\DepartmentApi;
use Yii;
use common\components\Athena\AthenaOauth;

class AthenaClient extends AthenaOauth
{
    const URL_SERVICE_DEPARTMENTS = "departments";
    const URL_SERVICE_PATIENT = "patients";

    public function getListDepartment()
    {
        $path = Yii::$app->params['version']."/".Yii::$app->params['practiceID']."/".self::URL_SERVICE_DEPARTMENTS;
        $dataResponse = $this->callMethod($path, 'GET');
        $dataApiModel = [];
        if($dataResponse['success']){
            foreach ($dataResponse['data']['departments'] as $key => $value){
                array_push($dataApiModel, new DepartmentApi($value));
            }

            return $dataApiModel;
        }else{
            return $dataResponse['message'];
        }
    }

    public function getDepartment($departmentID)
    {
        $path = Yii::$app->params['version']."/".Yii::$app->params['practiceID']."/".self::URL_SERVICE_DEPARTMENTS."/".$departmentID;
        $dataResponse = $this->callMethod($path, 'GET');
        if($dataResponse['success']){
            return $dataResponse['data'];
        }else{
            return $dataResponse['message'];
        }
    }

    public function createPatient(array $patientInfo)
    {
        $path = Yii::$app->params['version']."/".Yii::$app->params['practiceID']."/".self::URL_SERVICE_PATIENT;
        $dataResponse = $this->callMethod($path, 'POST', $patientInfo);
        if($dataResponse['success']){
            return $dataResponse['data'];
        }else{
            return $dataResponse['message'];
        }
    }
}