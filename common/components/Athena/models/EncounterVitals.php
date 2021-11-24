<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $encounter_id
 * @property Encounter $encounter
 * @property int $posting
 * @property Vitals[] $vitals
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class EncounterVitals extends \yii\db\ActiveRecord
{
 
    protected $_vitalsAr;

    public static function tableName()
    {
        return '{{%encounter_vitals}}';
    }

    public function rules()
    {
        return [
            [['encounter_id', 'posting', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getEncounter()
    {
        return $this->hasOne(Encounter::class, ['id' => 'encounter_id']);
    }

    public function getVitals()
    {
        return $this->hasMany(Vitals::class, ['encounter_vitals_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($encounter_id = ArrayHelper::getValue($apiObject, 'encounter_id')) {
            $this->encounter_id = $encounter_id;
        }
        if($encounter = ArrayHelper::getValue($apiObject, 'encounter')) {
            $this->encounter = $encounter;
        }
        if($posting = ArrayHelper::getValue($apiObject, 'posting')) {
            $this->posting = $posting;
        }
        if($vitals = ArrayHelper::getValue($apiObject, 'vitals')) {
            $this->_vitalsAr = $vitals;
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
        if( !empty($this->_vitalsAr) and is_array($this->_vitalsAr) ) {
            foreach($this->_vitalsAr as $vitalsApi) {
                $vitals = new Vitals();
                $vitals->loadApiObject($vitalsApi);
                $vitals->link('encounterVitals', $this);
                $vitals->save();
            }
        }

        return $saved;
    }
    */
}
