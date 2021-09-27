<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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

        if($appointmentid = ArrayHelper::getValue($apiObject, 'appointmentid')) {
            $this->appointmentid = $appointmentid;
        }
        if($closeddate = ArrayHelper::getValue($apiObject, 'closeddate')) {
            $this->closeddate = $closeddate;
        }
        if($closeduser = ArrayHelper::getValue($apiObject, 'closeduser')) {
            $this->closeduser = $closeduser;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($diagnoses = ArrayHelper::getValue($apiObject, 'diagnoses')) {
            $this->diagnoses = $diagnoses;
        }
        if($encounterdate = ArrayHelper::getValue($apiObject, 'encounterdate')) {
            $this->encounterdate = $encounterdate;
        }
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->encounterid = $encounterid;
        }
        if($encounterid = ArrayHelper::getValue($apiObject, 'encounterid')) {
            $this->externalId = $encounterid;
        }
        if($encountertype = ArrayHelper::getValue($apiObject, 'encountertype')) {
            $this->encountertype = $encountertype;
        }
        if($encountervisitname = ArrayHelper::getValue($apiObject, 'encountervisitname')) {
            $this->encountervisitname = $encountervisitname;
        }
        if($lastreopened = ArrayHelper::getValue($apiObject, 'lastreopened')) {
            $this->lastreopened = $lastreopened;
        }
        if($lastupdated = ArrayHelper::getValue($apiObject, 'lastupdated')) {
            $this->lastupdated = $lastupdated;
        }
        if($patientlocation = ArrayHelper::getValue($apiObject, 'patientlocation')) {
            $this->patientlocation = $patientlocation;
        }
        if($patientlocationid = ArrayHelper::getValue($apiObject, 'patientlocationid')) {
            $this->patientlocationid = $patientlocationid;
        }
        if($patientstatus = ArrayHelper::getValue($apiObject, 'patientstatus')) {
            $this->patientstatus = $patientstatus;
        }
        if($patientstatusid = ArrayHelper::getValue($apiObject, 'patientstatusid')) {
            $this->patientstatusid = $patientstatusid;
        }
        if($providerfirstname = ArrayHelper::getValue($apiObject, 'providerfirstname')) {
            $this->providerfirstname = $providerfirstname;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($providerlastname = ArrayHelper::getValue($apiObject, 'providerlastname')) {
            $this->providerlastname = $providerlastname;
        }
        if($providerphone = ArrayHelper::getValue($apiObject, 'providerphone')) {
            $this->providerphone = $providerphone;
        }
        if($stage = ArrayHelper::getValue($apiObject, 'stage')) {
            $this->stage = $stage;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
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
}
