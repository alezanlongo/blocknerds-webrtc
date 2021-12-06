<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestCreatePatientCase extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_create_patient_cases}}';
    }

    public function rules()
    {
        return [
            [['callbackname', 'callbacknumber', 'callbacknumbertype', 'documentsource', 'documentsubclass', 'internalnote', 'priority', 'subject'], 'trim'],
            [['departmentid', 'documentsource', 'documentsubclass', 'providerid'], 'required'],
            [['callbackname', 'callbacknumber', 'callbacknumbertype', 'documentsource', 'documentsubclass', 'internalnote', 'priority', 'subject'], 'string'],
            [['clinicalproviderid', 'departmentid', 'providerid', 'externalId', 'id'], 'integer'],
            [['autoclose', 'outboundonly'], 'boolean'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($autoclose = ArrayHelper::getValue($apiObject, 'autoclose')) {
            $this->autoclose = $autoclose;
        }
        if($callbackname = ArrayHelper::getValue($apiObject, 'callbackname')) {
            $this->callbackname = $callbackname;
        }
        if($callbacknumber = ArrayHelper::getValue($apiObject, 'callbacknumber')) {
            $this->callbacknumber = $callbacknumber;
        }
        if($callbacknumbertype = ArrayHelper::getValue($apiObject, 'callbacknumbertype')) {
            $this->callbacknumbertype = $callbacknumbertype;
        }
        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($documentsource = ArrayHelper::getValue($apiObject, 'documentsource')) {
            $this->documentsource = $documentsource;
        }
        if($documentsubclass = ArrayHelper::getValue($apiObject, 'documentsubclass')) {
            $this->documentsubclass = $documentsubclass;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($outboundonly = ArrayHelper::getValue($apiObject, 'outboundonly')) {
            $this->outboundonly = $outboundonly;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($subject = ArrayHelper::getValue($apiObject, 'subject')) {
            $this->subject = $subject;
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
