<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

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
 */
class EncounterApi extends Model
{

    public $appointmentid;
    public $closeddate;
    public $closeduser;
    public $departmentid;
    public $diagnoses;
 
    protected $_diagnosesAr;
    public $encounterdate;
    public $encounterid;
    public $encountertype;
    public $encountervisitname;
    public $lastreopened;
    public $lastupdated;
    public $patientlocation;
    public $patientlocationid;
    public $patientstatus;
    public $patientstatusid;
    public $providerfirstname;
    public $providerid;
    public $providerlastname;
    public $providerphone;
    public $stage;
    public $status;

    public function rules()
    {
        return [
            [['closeddate', 'closeduser', 'encounterdate', 'encountertype', 'encountervisitname', 'lastreopened', 'lastupdated', 'patientlocation', 'patientstatus', 'providerfirstname', 'providerlastname', 'providerphone', 'stage', 'status'], 'trim'],
            [['closeddate', 'closeduser', 'encounterdate', 'encountertype', 'encountervisitname', 'lastreopened', 'lastupdated', 'patientlocation', 'patientstatus', 'providerfirstname', 'providerlastname', 'providerphone', 'stage', 'status'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->diagnoses) && is_array($this->diagnoses)) {
            $this->_diagnosesAr = $this->diagnoses;
            $this->diagnoses = new Diagnoses($this->_diagnosesAr);
        }
    }

}
