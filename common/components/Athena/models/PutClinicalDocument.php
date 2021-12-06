<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $clinicalproviderid The ID of the external provider/lab/pharmacy associated the document.
 * @property int $documenttypeid A specific document type identifier.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes if replaceinternalnote is not set.
 * @property string $observationdate The date an observation was made (mm/dd/yyyy).
 * @property string $observationtime The time an observation was made (hh24:mi).  24 hour time.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property bool $replaceinternalnote If true, will replace the existing internal note with the new one. If false, will append to the existing note.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutClinicalDocument extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_clinical_documents}}';
    }

    public function rules()
    {
        return [
            [['internalnote', 'observationdate', 'observationtime', 'priority'], 'trim'],
            [['internalnote', 'observationdate', 'observationtime', 'priority'], 'string'],
            [['clinicalproviderid', 'documenttypeid', 'providerid', 'externalId', 'id'], 'integer'],
            [['replaceinternalnote'], 'boolean'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($observationdate = ArrayHelper::getValue($apiObject, 'observationdate')) {
            $this->observationdate = $observationdate;
        }
        if($observationtime = ArrayHelper::getValue($apiObject, 'observationtime')) {
            $this->observationtime = $observationtime;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
        }
        if($replaceinternalnote = ArrayHelper::getValue($apiObject, 'replaceinternalnote')) {
            $this->replaceinternalnote = $replaceinternalnote;
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
