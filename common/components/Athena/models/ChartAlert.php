<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $lastmodified The time this note was updated (mm/dd/yyyy hh24:mi:ss; Eastern time), if the note has been updated.
 * @property string $lastmodifiedby If the note has been modified, the username who last modified this note.
 * @property string $notetext The text of the note.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ChartAlert extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%chart_alerts}}';
    }

    public function rules()
    {
        return [
            [['lastmodified', 'lastmodifiedby', 'notetext'], 'trim'],
            [['lastmodified', 'lastmodifiedby', 'notetext'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($lastmodified = ArrayHelper::getValue($apiObject, 'lastmodified')) {
            $this->lastmodified = $lastmodified;
        }
        if($lastmodifiedby = ArrayHelper::getValue($apiObject, 'lastmodifiedby')) {
            $this->lastmodifiedby = $lastmodifiedby;
        }
        if($notetext = ArrayHelper::getValue($apiObject, 'notetext')) {
            $this->notetext = $notetext;
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
