<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property LabResult[] $departmentids list of lab results.
 * @property int $totalcount By default, you are subscribed to all possible events.  If you only wish to subscribe to an individual event, pass the event name with this argument.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResultChanged extends \yii\db\ActiveRecord
{
 
    protected $_departmentidsAr;

    public static function tableName()
    {
        return '{{%lab_result_changeds}}';
    }

    public function rules()
    {
        return [
            [['totalcount', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getDepartmentids()
    {
        return $this->hasMany(LabResult::class, ['lab_result_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentids = ArrayHelper::getValue($apiObject, 'departmentids')) {
            $this->_departmentidsAr = $departmentids;
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
        if( !empty($this->_departmentidsAr) and is_array($this->_departmentidsAr) ) {
            foreach($this->_departmentidsAr as $departmentidsApi) {
                $labresult = new LabResult();
                $labresult->loadApiObject($departmentidsApi);
                $labresult->link('labResultChanged', $this);
                $labresult->save();
            }
        }

        return $saved;
    }
    */
}
