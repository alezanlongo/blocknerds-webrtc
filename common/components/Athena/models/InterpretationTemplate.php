<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $interpretationtemplatename The name of the interpretation template.
 * @property string $interpretationtemplatenote The interpretation note.
 * @property Paragraph[] $paragraphs The paragraphs in the template.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class InterpretationTemplate extends \yii\db\ActiveRecord
{
 
    protected $_paragraphsAr;

    public static function tableName()
    {
        return '{{%interpretation_templates}}';
    }

    public function rules()
    {
        return [
            [['interpretationtemplatename', 'interpretationtemplatenote'], 'trim'],
            [['interpretationtemplatename', 'interpretationtemplatenote'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getParagraphs()
    {
        return $this->hasMany(Paragraph::class, ['interpretation_template_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($interpretationtemplatename = ArrayHelper::getValue($apiObject, 'interpretationtemplatename')) {
            $this->interpretationtemplatename = $interpretationtemplatename;
        }
        if($interpretationtemplatenote = ArrayHelper::getValue($apiObject, 'interpretationtemplatenote')) {
            $this->interpretationtemplatenote = $interpretationtemplatenote;
        }
        if($paragraphs = ArrayHelper::getValue($apiObject, 'paragraphs')) {
            $this->_paragraphsAr = $paragraphs;
        }
        if($externalId = ArrayHelper::getValue($apiObject, 'externalId')) {
            $this->externalId = $externalId;
        }
        if($id = ArrayHelper::getValue($apiObject, 'id')) {
            $this->id = $id;
        }

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
    /* FIXME link doesn't work
    public function save($runValidation = true, $attributeNames = null) {
        $saved = parent::save($runValidation, $attributeNames);
        if( !empty($this->_paragraphsAr) and is_array($this->_paragraphsAr) ) {
            foreach($this->_paragraphsAr as $paragraphsApi) {
                $paragraph = new Paragraph();
                $paragraph->loadApiObject($paragraphsApi);
                $paragraph->link('interpretationTemplate', $this);
                $paragraph->save();
            }
        }

        return $saved;
    }
    */
}
