<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property Patient[] $patients
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PatientChanged extends \yii\db\ActiveRecord
{
 
    protected $_patientsAr;

    public static function tableName()
    {
        return '{{%patient_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPatients()
    {
        return $this->hasMany(Patient::class, ['patient_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($patients = ArrayHelper::getValue($apiObject, 'patients')) {
            $this->_patientsAr = $patients;
        }
        if($totalcount = ArrayHelper::getValue($apiObject, 'totalcount')) {
            $this->totalcount = $totalcount;
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
        if( !empty($this->_patientsAr) and is_array($this->_patientsAr) ) {
            foreach($this->_patientsAr as $patientsApi) {
                $patient = new Patient();
                $patient->loadApiObject($patientsApi);
                $patient->link('patientChanged', $this);
                $patient->save();
            }
        }

        return $saved;
    }
    */
}
