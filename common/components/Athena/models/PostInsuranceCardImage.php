<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $departmentid The department ID associated with this upload.
 * @property string $image Base64 encoded image, or, if multipart/form-data, unencoded image. This image may be scaled down after submission. PUT is not recommended when using multipart/form-data. Since POST and PUT have identical functionality, POST is recommended.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostInsuranceCardImage extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_insurance_card_images}}';
    }

    public function rules()
    {
        return [
            [['departmentid', 'image'], 'trim'],
            [['image'], 'required'],
            [['departmentid', 'image'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($image = ArrayHelper::getValue($apiObject, 'image')) {
            $this->image = $image;
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
