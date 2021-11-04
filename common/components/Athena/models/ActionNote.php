<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The action notes that are attached to the document.
 * @property string $assignedto This field will describe who was assigned this document during this document action.
 * @property string $createdby The username of the person that created this document action.
 * @property string $createddatetime The datetime this action note was created.
 * @property int $patientid The patient ID this document is tied to.
 * @property int $priority Priority given for this document action.
 * @property string $status Status given for this document action.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ActionNote extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%action_notes}}';
    }

    public function rules()
    {
        return [
            [['actionnote', 'assignedto', 'createdby', 'createddatetime', 'status'], 'trim'],
            [['actionnote', 'assignedto', 'createdby', 'createddatetime', 'status'], 'string'],
            [['patientid', 'priority', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
        }
        if($assignedto = ArrayHelper::getValue($apiObject, 'assignedto')) {
            $this->assignedto = $assignedto;
        }
        if($createdby = ArrayHelper::getValue($apiObject, 'createdby')) {
            $this->createdby = $createdby;
        }
        if($createddatetime = ArrayHelper::getValue($apiObject, 'createddatetime')) {
            $this->createddatetime = $createddatetime;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
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
