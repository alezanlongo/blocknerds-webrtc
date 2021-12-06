<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Encounter $encounter
 * @property int $posting
 * @property Vitals[] $vitals
 */
class EncounterVitalsApi extends BaseApiModel
{

    public $encounter;
    public $posting;
    public $vitals;
 
    protected $_vitalsAr;

    public function rules()
    {
        return [
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->vitals) && is_array($this->vitals)) {
            foreach($this->vitals as $vitals) {
                $this->_vitalsAr[] = new VitalsApi($vitals);
            }
            $this->vitals = $this->_vitalsAr;
            $this->_vitalsAr = [];//CHECKME
        }
    }

}
