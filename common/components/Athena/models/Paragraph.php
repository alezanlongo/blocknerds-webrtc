<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $paragraphname The name of the interpretation paragraph.
 * @property Sentence[] $sentences The sentences in the paragraph.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Paragraph extends \yii\db\ActiveRecord
{
 
    protected $_sentencesAr;

    public static function tableName()
    {
        return '{{%paragraphs}}';
    }

    public function rules()
    {
        return [
            [['paragraphname'], 'trim'],
            [['paragraphname'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSentences()
    {
        return $this->hasMany(Sentence::class, ['paragraph_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($paragraphname = ArrayHelper::getValue($apiObject, 'paragraphname')) {
            $this->paragraphname = $paragraphname;
        }
        if($sentences = ArrayHelper::getValue($apiObject, 'sentences')) {
            $this->_sentencesAr = $sentences;
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
        if( !empty($this->_sentencesAr) and is_array($this->_sentencesAr) ) {
            foreach($this->_sentencesAr as $sentencesApi) {
                $sentence = new Sentence();
                $sentence->loadApiObject($sentencesApi);
                $sentence->link('paragraph', $this);
                $sentence->save();
            }
        }

        return $saved;
    }
    */
}
