<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property Finding[] $findings The findings in the sentence
 * @property string $sentencename The name of the sentence in the paragraph.
 * @property string $sentencenote The note that goes along with this sentence.
 */
class SentenceApi extends BaseApiModel
{

    public $findings;
 
    protected $_findingsAr;
    public $sentencename;
    public $sentencenote;

    public function rules()
    {
        return [
            [['sentencename', 'sentencenote'], 'trim'],
            [['sentencename', 'sentencenote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->findings) && is_array($this->findings)) {
            foreach($this->findings as $findings) {
                $this->_findingsAr[] = new FindingApi($findings);
            }
            $this->findings = $this->_findingsAr;
            $this->_findingsAr = [];//CHECKME
        }
    }

}
