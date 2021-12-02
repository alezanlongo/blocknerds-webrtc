<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $attachment The original document in uploaded format.
 */
class AdminDocumentOriginalDocumentApi extends BaseApiModel
{

    public $attachment;

    public function rules()
    {
        return [
            [['attachment'], 'trim'],
            [['attachment'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
