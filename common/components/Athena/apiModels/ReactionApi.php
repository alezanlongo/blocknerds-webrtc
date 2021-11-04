<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $reactionname Name of the reaction.
 * @property string $severity Severity of the reaction.
 * @property int $severitysnomedcode SNOMED code for the severity of this reaction.
 * @property int $snomedcode SNOMED code for this reaction.
 */
class ReactionApi extends BaseApiModel
{

    public $reactionname;
    public $severity;
    public $severitysnomedcode;
    public $snomedcode;

    public function rules()
    {
        return [
            [['reactionname', 'severity'], 'trim'],
            [['reactionname', 'severity'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
