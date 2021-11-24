<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property float $clinicalorderclassid The clinical order class id
 * @property string $dateonvis The VIS date associated with this vaccine and clinical order class id
 */
class VaccineInformationStatementsApi extends BaseApiModel
{

    public $clinicalorderclassid;
    public $dateonvis;

    public function rules()
    {
        return [
            [['dateonvis'], 'trim'],
            [['dateonvis'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
