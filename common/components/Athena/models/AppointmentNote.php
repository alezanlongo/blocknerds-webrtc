<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $created The time this note was created (mm/dd/yyyy hh24:mi:ss)
 * @property string $createdby The user that created this note.
 * @property string $deleted The time this note was deleted (mm/dd/yyyy hh24:mi:ss). Not present if not deleted.
 * @property string $deletedby If deleted, the username who deleted this note.
 * @property string $displayonschedule Determines if an appointment note displays on the homepage schedule view.
 * @property string $lastmodified The time this note was updated (mm/dd/yyyy hh24:mi:ss), if the note has been updated.
 * @property string $lastmodifiedby If the note has been modified, the username who last modified this note.
 * @property string $noteid The ID for this note, for use with DELETE and PUT calls.
 * @property string $notetext The text of the note itself.
 * @property integer $put_appointment200_response_id
 * @property PutAppointment200Response $put_appointment200_response
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AppointmentNote extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%appointment_notes}}';
    }

    public function rules()
    {
        return [
            [['created', 'createdby', 'deleted', 'deletedby', 'displayonschedule', 'lastmodified', 'lastmodifiedby', 'noteid', 'notetext'], 'trim'],
            [['created', 'createdby', 'deleted', 'deletedby', 'displayonschedule', 'lastmodified', 'lastmodifiedby', 'noteid', 'notetext'], 'string'],
            [['put_appointment200_response_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getPut_appointment200_response()
    {
        return $this->hasOne(PutAppointment200Response::class, ['id' => 'put_appointment200_response_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($created = ArrayHelper::getValue($apiObject, 'created')) {
            $this->created = $created;
        }
        if($createdby = ArrayHelper::getValue($apiObject, 'createdby')) {
            $this->createdby = $createdby;
        }
        if($deleted = ArrayHelper::getValue($apiObject, 'deleted')) {
            $this->deleted = $deleted;
        }
        if($deletedby = ArrayHelper::getValue($apiObject, 'deletedby')) {
            $this->deletedby = $deletedby;
        }
        if($displayonschedule = ArrayHelper::getValue($apiObject, 'displayonschedule')) {
            $this->displayonschedule = $displayonschedule;
        }
        if($lastmodified = ArrayHelper::getValue($apiObject, 'lastmodified')) {
            $this->lastmodified = $lastmodified;
        }
        if($lastmodifiedby = ArrayHelper::getValue($apiObject, 'lastmodifiedby')) {
            $this->lastmodifiedby = $lastmodifiedby;
        }
        if($noteid = ArrayHelper::getValue($apiObject, 'noteid')) {
            $this->noteid = $noteid;
        }
        if($noteid = ArrayHelper::getValue($apiObject, 'noteid')) {
            $this->externalId = $noteid;
        }
        if($notetext = ArrayHelper::getValue($apiObject, 'notetext')) {
            $this->notetext = $notetext;
        }
        if($put_appointment200_response_id = ArrayHelper::getValue($apiObject, 'put_appointment200_response_id')) {
            $this->put_appointment200_response_id = $put_appointment200_response_id;
        }
        if($put_appointment200_response = ArrayHelper::getValue($apiObject, 'put_appointment200_response')) {
            $this->put_appointment200_response = $put_appointment200_response;
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
