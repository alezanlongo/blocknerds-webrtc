<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property Finding[] $findings The findings in the sentence
 * @property string $sentencename The name of the sentence in the paragraph.
 * @property string $sentencenote The note that goes along with this sentence.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Sentence extends \yii\db\ActiveRecord
{
 
    protected $_findingsAr;

    public static function tableName()
    {
        return '{{%sentences}}';
    }

    public function rules()
    {
        return [
            [['sentencename', 'sentencenote'], 'trim'],
            [['sentencename', 'sentencenote'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getFindings()
    {
        return $this->hasMany(Finding::class, ['sentence_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($findings = ArrayHelper::getValue($apiObject, 'findings')) {
            $this->_findingsAr = $findings;
        }
        if($sentencename = ArrayHelper::getValue($apiObject, 'sentencename')) {
            $this->sentencename = $sentencename;
        }
        if($sentencenote = ArrayHelper::getValue($apiObject, 'sentencenote')) {
            $this->sentencenote = $sentencenote;
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
        if( !empty($this->_findingsAr) and is_array($this->_findingsAr) ) {
            foreach($this->_findingsAr as $findingsApi) {
                $finding = new Finding();
                $finding->loadApiObject($findingsApi);
                $finding->link('sentence', $this);
                $finding->save();
            }
        }

        return $saved;
    }
    */
}
