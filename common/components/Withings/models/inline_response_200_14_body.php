<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property workout_object[] $series
 * @property bool $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_14_body extends \yii\db\ActiveRecord
{
 
    protected $_seriesAr;

    public static function tableName()
    {
        return '{{%inline_response_200_14_bodies}}';
    }

    public function rules()
    {
        return [
            [['offset', 'externalId', 'id'], 'integer'],
            [['more'], 'boolean'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getSeries()
    {
        return $this->hasMany(workout_object::class, ['inline_response_200_14_body_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($series = ArrayHelper::getValue($apiObject, 'series')) {
            $this->_seriesAr = $series;
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
        if( !empty($this->_seriesAr) and is_array($this->_seriesAr) ) {
            foreach($this->_seriesAr as $seriesApi) {
                $workout_object = new workout_object();
                $workout_object->loadApiObject($seriesApi);
                $workout_object->link('inlineResponse20014Body', $this);
                $workout_object->save();
            }
        }

        return $saved;
    }
    */
}
