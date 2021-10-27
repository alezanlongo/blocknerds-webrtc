<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $actionnote The new action note to add to the document.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestActionNote extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_action_notes}}';
    }

    public function rules()
    {
        return [
            [['actionnote'], 'trim'],
            [['actionnote'], 'required'],
            [['actionnote'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($actionnote = ArrayHelper::getValue($apiObject, 'actionnote')) {
            $this->actionnote = $actionnote;
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
