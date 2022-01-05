<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $appli Refer to the [Notifications](/developer-guide/data-api/how-to-use-data-api) section to know the meaning of each values.
 * @property string $callbackurl Callback url of the notification.
 * @property int $expires Date at which the notification configuration will expire.
 * @property string $comment Comment entered when creating the notification configuration.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class notify_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%notify_objects}}';
    }

    public function rules()
    {
        return [
            [['callbackurl', 'comment'], 'trim'],
            [['callbackurl', 'comment'], 'string'],
            [['appli', 'expires', 'externalId', 'id'], 'integer'],
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
        if($expires = ArrayHelper::getValue($apiObject, 'expires')) {
            $this->expires = $expires;
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
