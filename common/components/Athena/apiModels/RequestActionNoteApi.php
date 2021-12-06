<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $actionnote The new action note to add to the document.
 */
class RequestActionNoteApi extends BaseApiModel
{

    public $actionnote;

    public function rules()
    {
        return [
            [['actionnote'], 'trim'],
            [['actionnote'], 'required'],
            [['actionnote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
