<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property int $appli Refer to the [Notifications](/developer-guide/data-api/how-to-use-data-api) section to know the meaning of each values.
 * @property string $callbackurl Callback url of the notification.
 * @property string $comment Comment entered when creating the notification configuration.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_3_body extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%inline_response_200_3_bodies}}';
    }

    public function rules()
    {
        return [
            [['callbackurl', 'comment'], 'trim'],
            [['callbackurl', 'comment'], 'string'],
            [['appli', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($appli = ArrayHelper::getValue($apiObject, 'appli')) {
            $this->appli = $appli;
        }
        if($callbackurl = ArrayHelper::getValue($apiObject, 'callbackurl')) {
            $this->callbackurl = $callbackurl;
        }
        if($comment = ArrayHelper::getValue($apiObject, 'comment')) {
            $this->comment = $comment;
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
