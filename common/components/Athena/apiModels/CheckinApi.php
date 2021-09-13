<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property string $message Debugging text in case of failure.
 * @property string $success Indicates that this call was successful.  Processing should still continue even if there was an error with this call.  Generally, this will only be false if the appointment is in a good state to start the process, but the startcheckin call was already used.  Other errors may occur, similar to potential errors with /appointments/{appointmentid}/checkin.
 */
class CheckinApi extends Model
{

    public $message;
    public $success;

    public function rules()
    {
        return [
            [['message', 'success'], 'trim'],
            [['message', 'success'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
