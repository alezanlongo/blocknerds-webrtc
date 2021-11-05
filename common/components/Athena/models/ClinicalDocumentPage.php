<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $attachment The image of the page in jpeg format.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ClinicalDocumentPage extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%clinical_document_pages}}';
    }

    public function rules()
    {
        return [
            [['attachment'], 'trim'],
            [['attachment'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($attachment = ArrayHelper::getValue($apiObject, 'attachment')) {
            $this->attachment = $attachment;
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
