<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $interpretationtemplatename The name of the interpretation template.
 * @property string $interpretationtemplatenote The interpretation note.
 * @property Paragraph[] $paragraphs The paragraphs in the template.
 */
class InterpretationTemplateApi extends BaseApiModel
{

    public $interpretationtemplatename;
    public $interpretationtemplatenote;
    public $paragraphs;
 
    protected $_paragraphsAr;

    public function rules()
    {
        return [
            [['interpretationtemplatename', 'interpretationtemplatenote'], 'trim'],
            [['interpretationtemplatename', 'interpretationtemplatenote'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
        if (!empty($this->paragraphs) && is_array($this->paragraphs)) {
            foreach($this->paragraphs as $paragraphs) {
                $this->_paragraphsAr[] = new ParagraphApi($paragraphs);
            }
            $this->paragraphs = $this->_paragraphsAr;
            $this->_paragraphsAr = [];//CHECKME
        }
    }

}
