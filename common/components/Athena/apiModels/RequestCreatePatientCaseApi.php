<?php

namespace common\components\Athena\apiModels;

use Yii;
use yii\base\Model;

/**
 * 
 *
 * @property bool $autoclose Documents will, normally, automatically appear in the clinical inbox for providers to review. In some cases, you might want to force the document to skip the clinical inbox, and go directly to the patient chart with a "closed" status. For that case, set this to true.
 * @property string $callbackname The name of the person to call (if other than patient).
 * @property string $callbacknumber The phone number to use to call back the patient (mutually exclusive with callbacknumbertype).
 * @property string $callbacknumbertype The phone number type to use to call back the patient (mutually exclusive with callbacknumber).
 * @property int $clinicalproviderid The ID of the external provider/lab/pharmacy associated the document.
 * @property int $departmentid The athenaNet department ID associated with the uploaded document.
 * @property string $documentsource Explains where this document originated.
 * @property string $documentsubclass Subclasses for PATIENTCASE documents
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property bool $outboundonly True/false flag indicating the patient case requires an outbound phone call and is not a response to an inbound call.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property string $subject The subject of this patient case.
 */
class RequestCreatePatientCaseApi extends Model
{

    public $autoclose;
    public $callbackname;
    public $callbacknumber;
    public $callbacknumbertype;
    public $clinicalproviderid;
    public $departmentid;
    public $documentsource;
    public $documentsubclass;
    public $internalnote;
    public $outboundonly;
    public $priority;
    public $providerid;
    public $subject;

    public function __construct(array $data)
    {
        foreach ($data as $key => $value){
            if(property_exists($this, $key)){
                $this->{$key} = $value;
            }
        }
    }

    public function rules()
    {
        return [
            [['callbackname', 'callbacknumber', 'callbacknumbertype', 'documentsource', 'documentsubclass', 'internalnote', 'priority', 'subject'], 'trim'],
            [['departmentid', 'documentsource', 'documentsubclass', 'providerid'], 'required'],
            [['callbackname', 'callbacknumber', 'callbacknumbertype', 'documentsource', 'documentsubclass', 'internalnote', 'priority', 'subject'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
