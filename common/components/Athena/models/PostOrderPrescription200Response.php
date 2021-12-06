<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $documentid The ID of the document created.
 * @property string $errormessage If the operation failed, this will contain any error messages.
 * @property string $success Whether the operation was successful.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostOrderPrescription200Response extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_order_prescription200_responses}}';
    }

    public function rules()
    {
        return [
            [['errormessage', 'success'], 'trim'],
            [['errormessage', 'success'], 'string'],
            [['documentid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($documentid = ArrayHelper::getValue($apiObject, 'documentid')) {
            $this->documentid = $documentid;
        }
        if($errormessage = ArrayHelper::getValue($apiObject, 'errormessage')) {
            $this->errormessage = $errormessage;
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
