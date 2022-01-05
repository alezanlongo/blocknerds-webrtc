<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property activity_object[] $activities
 * @property bool $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_12_body extends \yii\db\ActiveRecord
{
 
    protected $_activitiesAr;

    public static function tableName()
    {
        return '{{%inline_response_200_12_bodies}}';
    }

    public function rules()
    {
        return [
            [['offset', 'externalId', 'id'], 'integer'],
            [['more'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getActivities()
    {
        return $this->hasMany(activity_object::class, ['inline_response_200_12_body_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($activities = ArrayHelper::getValue($apiObject, 'activities')) {
            $this->_activitiesAr = $activities;
        }
        if($more = ArrayHelper::getValue($apiObject, 'more')) {
            $this->more = $more;
        }
        if($offset = ArrayHelper::getValue($apiObject, 'offset')) {
            $this->offset = $offset;
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
        if( !empty($this->_activitiesAr) and is_array($this->_activitiesAr) ) {
            foreach($this->_activitiesAr as $activitiesApi) {
                $activity_object = new activity_object();
                $activity_object->loadApiObject($activitiesApi);
                $activity_object->link('inlineResponse20012Body', $this);
                $activity_object->save();
            }
        }

        return $saved;
    }
    */
}
