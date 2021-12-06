<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property FamilyHistory[] $problems
 * @property int $totalcount
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class FamilyHistoryChanged extends \yii\db\ActiveRecord
{
 
    protected $_problemsAr;

    public static function tableName()
    {
        return '{{%family_history_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getProblems()
    {
        return $this->hasMany(FamilyHistory::class, ['family_history_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($problems = ArrayHelper::getValue($apiObject, 'problems')) {
            $this->_problemsAr = $problems;
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
        if( !empty($this->_problemsAr) and is_array($this->_problemsAr) ) {
            foreach($this->_problemsAr as $problemsApi) {
                $familyhistory = new FamilyHistory();
                $familyhistory->loadApiObject($problemsApi);
                $familyhistory->link('familyHistoryChanged', $this);
                $familyhistory->save();
            }
        }

        return $saved;
    }
    */
}
