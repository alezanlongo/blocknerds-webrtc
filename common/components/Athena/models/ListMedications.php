<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $lastdownloaddenialreason BETA FIELD: The reason the last medication history download was denied.
 * @property string $lastdownloaddenied BETA FIELD: Whether or not the last medication history download was denied.
 * @property string $lastdownloadeddate The time of the last attempted medication history download from SureScripts.
 * @property string $lastupdated The last time any of the medications were updated
 * @property array $medications The list of medications
 * @property string $nomedicationsreported Whether the patient explicitly has no reported medications
 * @property string $patientdownloadconsent Whether or not the patient has consented to have their medication history downloaded. There are plans to deprecate this field.
 * @property string $patientneedsdownloadconsent Whether or not the patient needs to consent to have medication history downloaded. This will be true if either the patient has not currently consented, or the practice is not enabled for these downloads.  This field is typically used when determining whether to message to the patient that they have not consented to these downloads. Note that regardless of this setting, medication history that has already been downloaded will remain available.
 * @property string $sectionnote A section-wide note
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ListMedications extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%list_medications}}';
    }

    public function rules()
    {
        return [
            [['lastdownloaddenialreason', 'lastdownloaddenied', 'lastdownloadeddate', 'lastupdated', 'nomedicationsreported', 'patientdownloadconsent', 'patientneedsdownloadconsent', 'sectionnote'], 'trim'],
            [['lastdownloaddenialreason', 'lastdownloaddenied', 'lastdownloadeddate', 'lastupdated', 'nomedicationsreported', 'patientdownloadconsent', 'patientneedsdownloadconsent', 'sectionnote'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($lastdownloaddenialreason = ArrayHelper::getValue($apiObject, 'lastdownloaddenialreason')) {
            $this->lastdownloaddenialreason = $lastdownloaddenialreason;
        }
        if($lastdownloaddenied = ArrayHelper::getValue($apiObject, 'lastdownloaddenied')) {
            $this->lastdownloaddenied = $lastdownloaddenied;
        }
        if($lastdownloadeddate = ArrayHelper::getValue($apiObject, 'lastdownloadeddate')) {
            $this->lastdownloadeddate = $lastdownloadeddate;
        }
        if($lastupdated = ArrayHelper::getValue($apiObject, 'lastupdated')) {
            $this->lastupdated = $lastupdated;
        }
        if($medications = ArrayHelper::getValue($apiObject, 'medications')) {
            $this->medications = $medications;
        }
        if($nomedicationsreported = ArrayHelper::getValue($apiObject, 'nomedicationsreported')) {
            $this->nomedicationsreported = $nomedicationsreported;
        }
        if($patientdownloadconsent = ArrayHelper::getValue($apiObject, 'patientdownloadconsent')) {
            $this->patientdownloadconsent = $patientdownloadconsent;
        }
        if($patientneedsdownloadconsent = ArrayHelper::getValue($apiObject, 'patientneedsdownloadconsent')) {
            $this->patientneedsdownloadconsent = $patientneedsdownloadconsent;
        }
        if($sectionnote = ArrayHelper::getValue($apiObject, 'sectionnote')) {
            $this->sectionnote = $sectionnote;
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
