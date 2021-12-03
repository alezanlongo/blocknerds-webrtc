<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $adminid The document ID of the edited document.
 * @property string $documentdate The date an observation was made (mm/dd/yyyy).
 * @property int $documenttypeid A specific document type identifier.
 * @property string $internalnote An internal note for the provider or staff. Updating this will append to any previous notes.
 * @property string $priority Priority of this result.  1 is high; 2 is normal.
 * @property int $providerid The ID of the ordering provider.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutAdminDocument extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_admin_documents}}';
    }

    public function rules()
    {
        return [
            [['documentdate', 'internalnote', 'priority'], 'trim'],
            [['documentdate', 'internalnote', 'priority'], 'string'],
            [['adminid', 'documenttypeid', 'providerid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($adminid = ArrayHelper::getValue($apiObject, 'adminid')) {
            $this->adminid = $adminid;
        }
        if($documentdate = ArrayHelper::getValue($apiObject, 'documentdate')) {
            $this->documentdate = $documentdate;
        }
        if($documenttypeid = ArrayHelper::getValue($apiObject, 'documenttypeid')) {
            $this->documenttypeid = $documenttypeid;
        }
        if($internalnote = ArrayHelper::getValue($apiObject, 'internalnote')) {
            $this->internalnote = $internalnote;
        }
        if($priority = ArrayHelper::getValue($apiObject, 'priority')) {
            $this->priority = $priority;
        }
        if($providerid = ArrayHelper::getValue($apiObject, 'providerid')) {
            $this->providerid = $providerid;
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
