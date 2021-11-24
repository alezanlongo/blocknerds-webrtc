<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property int $allergenid Athena ID for this allergen.
 * @property string $allergenname The name of the allergen.
 * @property string $deactivatedate Date of allergy deactivation. Set to deactivate the allergy.
 * @property string $note Note about this allergy.
 * @property string $onsetdate Date of allergy onset.
 * @property string $patientid The Patient ID associated with the allergy.
 * @property Reaction[] $reactions List of documented reactions.
 */
class AllergyApi extends BaseApiModel
{

    public $allergenid;
    public $allergenname;
    public $deactivatedate;
    public $note;
    public $onsetdate;
    public $patientid;
    public $reactions;
 
    protected $_reactionsAr;

    public function rules()
    {
        return [
            [['allergenname', 'deactivatedate', 'note', 'onsetdate', 'patientid'], 'trim'],
            [['allergenname', 'deactivatedate', 'note', 'onsetdate', 'patientid'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->reactions) && is_array($this->reactions)) {
            foreach($this->reactions as $reactions) {
                $this->_reactionsAr[] = new ReactionApi($reactions);
            }
            $this->reactions = $this->_reactionsAr;
            $this->_reactionsAr = [];//CHECKME
        }
    }

}
