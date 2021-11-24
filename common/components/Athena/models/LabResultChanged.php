<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property LabResult[] $labresults list of lab results.
 * @property int $totalcount By default, you are subscribed to all possible events.  If you only wish to subscribe to an individual event, pass the event name with this argument.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResultChanged extends \yii\db\ActiveRecord
{
 
    protected $_labresultsAr;

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

    public function getLabresults()
    {
        return $this->hasMany(LabResult::class, ['lab_result_changed_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($labresults = ArrayHelper::getValue($apiObject, 'labresults')) {
            $this->_labresultsAr = $labresults;
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
        if( !empty($this->_labresultsAr) and is_array($this->_labresultsAr) ) {
            foreach($this->_labresultsAr as $labresultsApi) {
                $labresult = new LabResult();
                $labresult->loadApiObject($labresultsApi);
                $labresult->link('labResultChanged', $this);
                $labresult->save();
            }
        }

        return $saved;
    }
    */
}
