<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage Error message will be returned if show error message flag is set to true and patient match found.
 * @property string $problemid Please remember to never disclose this ID to patients since it may result in inadvertant disclosure that a patient exists in a practice already.
 * @property string $success
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostProblem200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_problem200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'problemid', 'success'], 'trim'],
            [['errormessage', 'problemid', 'success'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->problemid = $problemid;
        }
        if($problemid = ArrayHelper::getValue($apiObject, 'problemid')) {
            $this->externalId = $problemid;
        }
        if($success = ArrayHelper::getValue($apiObject, 'success')) {
            $this->success = $success;
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
