<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property Medication[] $medications
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class MedicationChanged extends \yii\db\ActiveRecord
{
 
    protected $_medicationsAr;

    public static function tableName()
    {
        return '{{%medication_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getMedications()
    {
        return $this->hasMany(Medication::class, ['medication_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($medications = ArrayHelper::getValue($apiObject, 'medications')) {
            $this->_medicationsAr = $medications;
        }
        if($totalcount = ArrayHelper::getValue($apiObject, 'totalcount')) {
            $this->totalcount = $totalcount;
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
        if( !empty($this->_medicationsAr) and is_array($this->_medicationsAr) ) {
            foreach($this->_medicationsAr as $medicationsApi) {
                $medication = new Medication();
                $medication->loadApiObject($medicationsApi);
                $medication->link('medicationChanged', $this);
                $medication->save();
            }
        }

        return $saved;
    }
    */
}
