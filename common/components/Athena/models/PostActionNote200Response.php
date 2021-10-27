<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $errormessage If there was an error with this call and SUCCESS is set to false, this field may provide additional information.
 * @property string $newdocumentid The document ID of newly created document as a result of action of Deny-New Prescription To Follow (DNTF).
 * @property string $success Returns true if the update was a success.
 * @property string $versiontoken A token representing the current state of this document. Will only be set if VERSIONTOKEN was originally sent to the endpoint.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostActionNote200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_action_note200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'newdocumentid', 'success', 'versiontoken'], 'trim'],
            [['errormessage', 'newdocumentid', 'success', 'versiontoken'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
        }
        if($newdocumentid = ArrayHelper::getValue($apiObject, 'newdocumentid')) {
            $this->newdocumentid = $newdocumentid;
        }
        if($success = ArrayHelper::getValue($apiObject, 'success')) {
            $this->success = $success;
        }
        if($versiontoken = ArrayHelper::getValue($apiObject, 'versiontoken')) {
            $this->versiontoken = $versiontoken;
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
