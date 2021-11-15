<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $actionnote The note to be added to the document
 */
class PutLabResultDataEntryCompleteApi extends BaseApiModel
{

    public $actionnote;

    public function rules()
    {
        return [
            [['actionnote'], 'trim'],
            [['actionnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
