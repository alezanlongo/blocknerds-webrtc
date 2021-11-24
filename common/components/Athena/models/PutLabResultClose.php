<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The note to be added to the document
 * @property int $actionreasonid An alternate action reason to be applied the document
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PutLabResultClose extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%put_lab_result_closes}}';
    }

    public function rules()
    {
        return [
            [['actionnote'], 'trim'],
            [['actionnote'], 'string'],
            [['actionreasonid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
        }
        if($actionreasonid = ArrayHelper::getValue($apiObject, 'actionreasonid')) {
            $this->actionreasonid = $actionreasonid;
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
