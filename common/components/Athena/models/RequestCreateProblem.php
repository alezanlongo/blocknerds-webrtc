<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property bool $PATIENTFACINGCALL When 'true' is passed we will collect relevant data and store in our database.
 * @property string $THIRDPARTYUSERNAME User name of the patient in the third party application.
 * @property int $departmentid The athenaNet department id.
 * @property string $laterality Update the laterality of this problem. Can be null, LEFT, RIGHT, or BILATERAL.
 * @property string $note The note to be attached to this problem.
 * @property int $snomedcode The <a href="http://www.nlm.nih.gov/research/umls/Snomed/snomed_browsers.html">SNOMED code</a> of the problem you are adding.
 * @property string $startdate The onset date to be updated for this problem in MM/DD/YYYY format.
 * @property string $status Whether the problem is chronic or acute.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreateProblem extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_problems}}';
    }

    public function rules()
    {
        return [
            [['THIRDPARTYUSERNAME', 'laterality', 'note', 'startdate', 'status'], 'trim'],
            [['departmentid', 'snomedcode'], 'required'],
            [['THIRDPARTYUSERNAME', 'laterality', 'note', 'startdate', 'status'], 'string'],
            [['departmentid', 'snomedcode', 'externalId', 'id'], 'integer'],
            [['PATIENTFACINGCALL'], 'boolean'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($PATIENTFACINGCALL = ArrayHelper::getValue($apiObject, 'PATIENTFACINGCALL')) {
            $this->PATIENTFACINGCALL = $PATIENTFACINGCALL;
        }
        if($THIRDPARTYUSERNAME = ArrayHelper::getValue($apiObject, 'THIRDPARTYUSERNAME')) {
            $this->THIRDPARTYUSERNAME = $THIRDPARTYUSERNAME;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($laterality = ArrayHelper::getValue($apiObject, 'laterality')) {
            $this->laterality = $laterality;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($snomedcode = ArrayHelper::getValue($apiObject, 'snomedcode')) {
            $this->snomedcode = $snomedcode;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
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
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);

        return $saved;
    }
    */
}
