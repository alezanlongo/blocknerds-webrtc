<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $checkboxesconfigured The number of checkboxes the practice has configured.
 * @property object $insuredsignature
 * @property object $patientsignature
 * @property object $privacynotice
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PrivacyInformationVerified extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%privacy_information_verifieds}}';
    }

    public function rules()
    {
        return [
            [['checkboxesconfigured', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($checkboxesconfigured = ArrayHelper::getValue($apiObject, 'checkboxesconfigured')) {
            $this->checkboxesconfigured = $checkboxesconfigured;
        }
        if($insuredsignature = ArrayHelper::getValue($apiObject, 'insuredsignature')) {
            $this->insuredsignature = $insuredsignature;
        }
        if($patientsignature = ArrayHelper::getValue($apiObject, 'patientsignature')) {
            $this->patientsignature = $patientsignature;
        }
        if($privacynotice = ArrayHelper::getValue($apiObject, 'privacynotice')) {
            $this->privacynotice = $privacynotice;
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
