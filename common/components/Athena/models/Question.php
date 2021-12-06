<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $answer The answer
 * @property string $question The question
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Question extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%questions}}';
    }

    public function rules()
    {
        return [
            [['answer', 'question'], 'trim'],
            [['answer', 'question'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($answer = ArrayHelper::getValue($apiObject, 'answer')) {
            $this->answer = $answer;
        }
        if($question = ArrayHelper::getValue($apiObject, 'question')) {
            $this->question = $question;
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
