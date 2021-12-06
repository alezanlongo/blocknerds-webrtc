<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $actionnote The note to be added to the document
 * @property int $actionreasonid An alternate action reason to be applied the document
 */
class PutLabResultCloseApi extends BaseApiModel
{

    public $actionnote;
    public $actionreasonid;

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
