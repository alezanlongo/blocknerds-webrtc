<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $code Authorization Code that must be used to retrieve access_token and refresh_token. (Cf. [Token Reception](/developer-guide/logistics-api/authentication#token-reception) section)
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_1_body_user extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_1_body_users}}';
    }

    public function rules()
    {
        return [
            [['code'], 'trim'],
            [['code'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($code = ArrayHelper::getValue($apiObject, 'code')) {
            $this->code = $code;
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
