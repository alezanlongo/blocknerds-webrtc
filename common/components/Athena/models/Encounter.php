<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property int $appointmentid Athena appointment ID resulting in this encounter
 * @property string $closeddate date when this encounter was closed
 * @property string $closeduser Username of the provider who closed this encounter
 * @property int $departmentid The athena department ID of this encounter
 * @property Diagnoses[] $diagnoses List of diagnoses for this encounter
 * @property string $encounterdate Date when this encounter occured
 * @property int $encounterid Athena ID for this encounter
 * @property string $encountertype Type of encounter (FLOWSHEET, ORDERSONLY, VISIT, etc.). By default only VISIT and ORDERSONLY are shown, use INCLUDEALLtypeS flag to see others.
 * @property string $encountervisitname The visit name for this encounter
 * @property string $lastreopened The date the encounter was last reopened. The field will not be present if the encounter has not be closed.
 * @property string $lastupdated The date the encounter was last updated
 * @property string $patientlocation Patient location
 * @property int $patientlocationid Athena ID for the patient location
 * @property string $patientstatus Patient status
 * @property int $patientstatusid Athena ID for the patient status
 * @property string $providerfirstname First name of the provider for this encounter
 * @property int $providerid The ID of the provider for this encounter
 * @property string $providerlastname Last name of the provider for this encounter
 * @property string $providerphone Phone number of the provider for this encounter
 * @property string $stage Last stage of the encounter
 * @property string $status Status of this encounter (CLOSED, OPEN, PEND). By default only OPEN, CLOSED, and REVIEW statuses are shown, use INCLUDEALLSTATUSES flag to see others.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Encounter extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%encounters}}';
    }

    public function rules()
    {
        return [
            [['closeddate', 'closeduser', 'encounterdate', 'encountertype', 'encountervisitname', 'lastreopened', 'lastupdated', 'patientlocation', 'patientstatus', 'providerfirstname', 'providerlastname', 'providerphone', 'stage', 'status'], 'trim'],
            [['closeddate', 'closeduser', 'encounterdate', 'encountertype', 'encountervisitname', 'lastreopened', 'lastupdated', 'patientlocation', 'patientstatus', 'providerfirstname', 'providerlastname', 'providerphone', 'stage', 'status'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getDiagnoses()
    {
        return $this->hasMany(Diagnoses::class, ['encounter_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->appointmentid = ArrayHelper::getValue($obj, 'appointmentid');
        $this->closeddate = ArrayHelper::getValue($obj, 'closeddate');
        $this->closeduser = ArrayHelper::getValue($obj, 'closeduser');
        $this->departmentid = ArrayHelper::getValue($obj, 'departmentid');
        $this->diagnoses = ArrayHelper::getValue($obj, 'diagnoses');
        $this->encounterdate = ArrayHelper::getValue($obj, 'encounterdate');
        $this->encounterid = ArrayHelper::getValue($obj, 'encounterid');
        $this->encountertype = ArrayHelper::getValue($obj, 'encountertype');
        $this->encountervisitname = ArrayHelper::getValue($obj, 'encountervisitname');
        $this->lastreopened = ArrayHelper::getValue($obj, 'lastreopened');
        $this->lastupdated = ArrayHelper::getValue($obj, 'lastupdated');
        $this->patientlocation = ArrayHelper::getValue($obj, 'patientlocation');
        $this->patientlocationid = ArrayHelper::getValue($obj, 'patientlocationid');
        $this->patientstatus = ArrayHelper::getValue($obj, 'patientstatus');
        $this->patientstatusid = ArrayHelper::getValue($obj, 'patientstatusid');
        $this->providerfirstname = ArrayHelper::getValue($obj, 'providerfirstname');
        $this->providerid = ArrayHelper::getValue($obj, 'providerid');
        $this->providerlastname = ArrayHelper::getValue($obj, 'providerlastname');
        $this->providerphone = ArrayHelper::getValue($obj, 'providerphone');
        $this->stage = ArrayHelper::getValue($obj, 'stage');
        $this->status = ArrayHelper::getValue($obj, 'status');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
