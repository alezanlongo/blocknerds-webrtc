<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $image Base64 encoded image.
 * @property int $insuranceid The athena ID of the insurance
 * @property integer $patientInsurance_id
 * @property PatientInsurance $patientInsurance
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class InsuranceCardImage extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%insurance_card_images}}';
    }

    public function rules()
    {
        return [
            [['image'], 'trim'],
            [['image'], 'string'],
            [['insuranceid', 'patientInsurance_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPatientInsurance()
    {
        return $this->hasOne(PatientInsurance::class, ['id' => 'patientInsurance_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($image = ArrayHelper::getValue($apiObject, 'image')) {
            $this->image = $image;
        }
        if($insuranceid = ArrayHelper::getValue($apiObject, 'insuranceid')) {
            $this->insuranceid = $insuranceid;
        }
        if($patientInsurance_id = ArrayHelper::getValue($apiObject, 'patientInsurance_id')) {
            $this->patientInsurance_id = $patientInsurance_id;
        }
        if($patientInsurance = ArrayHelper::getValue($apiObject, 'patientInsurance')) {
            $this->patientInsurance = $patientInsurance;
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
