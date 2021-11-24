<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $medicationentryid If successful, the athena ID of the newly created historical medication
 * @property string $success Whether the operation was successful or not.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostMedication200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_medication200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'medicationentryid', 'success'], 'trim'],
            [['errormessage', 'medicationentryid', 'success'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($medicationentryid = ArrayHelper::getValue($apiObject, 'medicationentryid')) {
            $this->medicationentryid = $medicationentryid;
        }
        if($medicationentryid = ArrayHelper::getValue($apiObject, 'medicationentryid')) {
            $this->externalId = $medicationentryid;
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
