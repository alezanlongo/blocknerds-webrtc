<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $code The code in the external vocabulary.
 * @property string $codeset Name of the external vocabulary. Currently LOINC (for labs and some imaging orders), CVX (for vaccines), RXNORM and NDC (for prescriptions and some DMEs).
 * @property string $description When available, a description of the code from the external vocabulary.
 */
class ExternalCodeApi extends BaseApiModel
{

    public $code;
    public $codeset;
    public $description;

    public function rules()
    {
        return [
            [['code', 'codeset', 'description'], 'trim'],
            [['code', 'codeset', 'description'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
