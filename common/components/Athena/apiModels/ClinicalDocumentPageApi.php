<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $attachment The image of the page in jpeg format.
 */
class ClinicalDocumentPageApi extends BaseApiModel
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
