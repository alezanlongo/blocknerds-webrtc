<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $appli Refer to the [Notifications](/developer-guide/data-api/how-to-use-data-api) section to know the meaning of each values.
 * @property string $callbackurl Callback url of the notification.
 * @property int $expires Date at which the notification configuration will expire.
 * @property string $comment Comment entered when creating the notification configuration.
 */
class notify_objectApi extends BaseApiModel
{

    public $appli;
    public $callbackurl;
    public $expires;
    public $comment;

    public function rules()
    {
        return [
            [['callbackurl', 'comment'], 'trim'],
            [['callbackurl', 'comment'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
