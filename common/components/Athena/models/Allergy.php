<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $allergenid Athena ID for this allergen.
 * @property string $allergenname The name of the allergen.
 * @property string $deactivatedate Date of allergy deactivation. Set to deactivate the allergy.
 * @property string $note Note about this allergy.
 * @property string $onsetdate Date of allergy onset.
 * @property string $patientid The Patient ID associated with the allergy.
 * @property Reaction[] $reactions List of documented reactions.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Allergy extends \yii\db\ActiveRecord
{
 
    protected $_reactionsAr;

    public static function tableName()
    {
        return '{{%allergies}}';
    }

    public function rules()
    {
        return [
            [['allergenname', 'deactivatedate', 'note', 'onsetdate', 'patientid'], 'trim'],
            [['allergenname', 'deactivatedate', 'note', 'onsetdate', 'patientid'], 'string'],
            [['allergenid', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getReactions()
    {
        return $this->hasMany(Reaction::class, ['allergy_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($allergenid = ArrayHelper::getValue($apiObject, 'allergenid')) {
            $this->allergenid = $allergenid;
        }
        if($allergenid = ArrayHelper::getValue($apiObject, 'allergenid')) {
            $this->externalId = $allergenid;
        }
        if($allergenname = ArrayHelper::getValue($apiObject, 'allergenname')) {
            $this->allergenname = $allergenname;
        }
        if($deactivatedate = ArrayHelper::getValue($apiObject, 'deactivatedate')) {
            $this->deactivatedate = $deactivatedate;
        }
        if($note = ArrayHelper::getValue($apiObject, 'note')) {
            $this->note = $note;
        }
        if($onsetdate = ArrayHelper::getValue($apiObject, 'onsetdate')) {
            $this->onsetdate = $onsetdate;
        }
        if($patientid = ArrayHelper::getValue($apiObject, 'patientid')) {
            $this->patientid = $patientid;
        }
        if($reactions = ArrayHelper::getValue($apiObject, 'reactions')) {
            $this->_reactionsAr = $reactions;
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
        if( !empty($this->_reactionsAr) and is_array($this->_reactionsAr) ) {
            foreach($this->_reactionsAr as $reactionsApi) {
                $reaction = new Reaction();
                $reaction->loadApiObject($reactionsApi);
                $reaction->link('allergy', $this);
                $reaction->save();
            }
        }

        return $saved;
    }
    */
}
