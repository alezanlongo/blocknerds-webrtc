<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property Vaccine[] $vaccines
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class VaccineChanged extends \yii\db\ActiveRecord
{
 
    protected $_vaccinesAr;

    public static function tableName()
    {
        return '{{%vaccine_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getVaccines()
    {
        return $this->hasMany(Vaccine::class, ['vaccine_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($vaccines = ArrayHelper::getValue($apiObject, 'vaccines')) {
            $this->_vaccinesAr = $vaccines;
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
        if( !empty($this->_vaccinesAr) and is_array($this->_vaccinesAr) ) {
            foreach($this->_vaccinesAr as $vaccinesApi) {
                $vaccine = new Vaccine();
                $vaccine->loadApiObject($vaccinesApi);
                $vaccine->link('vaccineChanged', $this);
                $vaccine->save();
            }
        }

        return $saved;
    }
    */
}
