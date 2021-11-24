<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $paragraphname The name of the interpretation paragraph.
 * @property Sentence[] $sentences The sentences in the paragraph.
 */
class ParagraphApi extends BaseApiModel
{

    public $paragraphname;
    public $sentences;
 
    protected $_sentencesAr;

    public function rules()
    {
        return [
            [['paragraphname'], 'trim'],
            [['paragraphname'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->sentences) && is_array($this->sentences)) {
            foreach($this->sentences as $sentences) {
                $this->_sentencesAr[] = new SentenceApi($sentences);
            }
            $this->sentences = $this->_sentencesAr;
            $this->_sentencesAr = [];//CHECKME
        }
    }

}
