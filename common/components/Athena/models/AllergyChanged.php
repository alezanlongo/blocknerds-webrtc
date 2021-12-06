<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property Allergy[] $allergies
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AllergyChanged extends \yii\db\ActiveRecord
{
 
    protected $_allergiesAr;

    public static function tableName()
    {
        return '{{%allergy_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getAllergies()
    {
        return $this->hasMany(Allergy::class, ['allergy_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($allergies = ArrayHelper::getValue($apiObject, 'allergies')) {
            $this->_allergiesAr = $allergies;
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
        if( !empty($this->_allergiesAr) and is_array($this->_allergiesAr) ) {
            foreach($this->_allergiesAr as $allergiesApi) {
                $allergy = new Allergy();
                $allergy->loadApiObject($allergiesApi);
                $allergy->link('allergyChanged', $this);
                $allergy->save();
            }
        }

        return $saved;
    }
    */
}
