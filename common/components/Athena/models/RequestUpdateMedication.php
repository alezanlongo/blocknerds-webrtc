<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $departmentid The athenanet department ID
 * @property bool $hidden Set whether the medication is hidden in the UI.
 * @property string $patientnote A patient-facing note
 * @property string $providernote An internal note
 * @property string $startdate Start date for this medication
 * @property string $stopdate Stop date for this medication
 * @property string $stopreason The reason the medication was stopped. If set, it it recommended but not required that a stop date is also set.
 * @property string $unstructuredsig Can only be used to update historical (entered, downloaded, etc) medications. Will override a structured sig if there is one.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestUpdateMedication extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_update_medications}}';
    }

    public function rules()
    {
        return [
            [['patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'trim'],
            [['departmentid'], 'required'],
            [['patientnote', 'providernote', 'startdate', 'stopdate', 'stopreason', 'unstructuredsig'], 'string'],
            [['departmentid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($hidden = ArrayHelper::getValue($apiObject, 'hidden')) {
            $this->hidden = $hidden;
        }
        if($patientnote = ArrayHelper::getValue($apiObject, 'patientnote')) {
            $this->patientnote = $patientnote;
        }
        if($providernote = ArrayHelper::getValue($apiObject, 'providernote')) {
            $this->providernote = $providernote;
        }
        if($startdate = ArrayHelper::getValue($apiObject, 'startdate')) {
            $this->startdate = $startdate;
        }
        if($stopdate = ArrayHelper::getValue($apiObject, 'stopdate')) {
            $this->stopdate = $stopdate;
        }
        if($stopreason = ArrayHelper::getValue($apiObject, 'stopreason')) {
            $this->stopreason = $stopreason;
        }
        if($unstructuredsig = ArrayHelper::getValue($apiObject, 'unstructuredsig')) {
            $this->unstructuredsig = $unstructuredsig;
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
