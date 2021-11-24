<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $findingname The name of the finding.
 * @property string $findingnote The note for the finding selected.
 * @property string $findingtype Describes the finding - either NORMAL, ABNORMAL, or NEUTRAL.
 * @property string $freetext Freetext that could be associated with this finding.
 * @property array $selectedoptions The option in the finding that was selected by the user.
 */
class FindingApi extends BaseApiModel
{

    public $findingname;
    public $findingnote;
    public $findingtype;
    public $freetext;
    public $selectedoptions;

    public function rules()
    {
        return [
            [['findingname', 'findingnote', 'findingtype', 'freetext'], 'trim'],
            [['findingname', 'findingnote', 'findingtype', 'freetext'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
