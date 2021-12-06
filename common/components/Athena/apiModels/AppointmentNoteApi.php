<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $created The time this note was created (mm/dd/yyyy hh24:mi:ss)
 * @property string $createdby The user that created this note.
 * @property string $deleted The time this note was deleted (mm/dd/yyyy hh24:mi:ss). Not present if not deleted.
 * @property string $deletedby If deleted, the username who deleted this note.
 * @property string $displayonschedule Determines if an appointment note displays on the homepage schedule view.
 * @property string $lastmodified The time this note was updated (mm/dd/yyyy hh24:mi:ss), if the note has been updated.
 * @property string $lastmodifiedby If the note has been modified, the username who last modified this note.
 * @property string $noteid The ID for this note, for use with DELETE and PUT calls.
 * @property string $notetext The text of the note itself.
 * @property PutAppointment200Response $put_appointment200_response
 */
class AppointmentNoteApi extends BaseApiModel
{

    public $created;
    public $createdby;
    public $deleted;
    public $deletedby;
    public $displayonschedule;
    public $lastmodified;
    public $lastmodifiedby;
    public $noteid;
    public $notetext;
    public $put_appointment200_response;

    public function rules()
    {
        return [
            [['created', 'createdby', 'deleted', 'deletedby', 'displayonschedule', 'lastmodified', 'lastmodifiedby', 'noteid', 'notetext'], 'trim'],
            [['created', 'createdby', 'deleted', 'deletedby', 'displayonschedule', 'lastmodified', 'lastmodifiedby', 'noteid', 'notetext'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
