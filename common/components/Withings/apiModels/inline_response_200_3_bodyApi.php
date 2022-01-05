<?php

namespace common\components\Withings\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * Response data.
 *
 * @property int $appli Refer to the [Notifications](/developer-guide/data-api/how-to-use-data-api) section to know the meaning of each values.
 * @property string $callbackurl Callback url of the notification.
 * @property string $comment Comment entered when creating the notification configuration.
 */
class inline_response_200_3_bodyApi extends BaseApiModel
{

    public $appli;
    public $callbackurl;
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
