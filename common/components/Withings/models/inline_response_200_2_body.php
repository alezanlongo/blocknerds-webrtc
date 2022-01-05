<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property string $updatetime Server time at which the answer was generated.
 * @property string $timezone Timezone for the date.
 * @property measuregrp_object[] $measuregrps Measures are returned in groups.
 * @property int $more To know if there is more data to fetch or not.
 * @property int $offset Offset to use to retrieve the next data.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_2_body extends \yii\db\ActiveRecord
{
 
    protected $_measuregrpsAr;

    public static function tableName()
    {
        return '{{%inline_response_200_2_bodies}}';
    }

    public function rules()
    {
        return [
            [['updatetime', 'timezone'], 'trim'],
            [['updatetime', 'timezone'], 'string'],
            [['more', 'offset', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getMeasuregrps()
    {
        return $this->hasMany(measuregrp_object::class, ['inline_response_200_2_body_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($updatetime = ArrayHelper::getValue($apiObject, 'updatetime')) {
            $this->updatetime = $updatetime;
        }
        if($timezone = ArrayHelper::getValue($apiObject, 'timezone')) {
            $this->timezone = $timezone;
        }
        if($measuregrps = ArrayHelper::getValue($apiObject, 'measuregrps')) {
            $this->_measuregrpsAr = $measuregrps;
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
        if( !empty($this->_measuregrpsAr) and is_array($this->_measuregrpsAr) ) {
            foreach($this->_measuregrpsAr as $measuregrpsApi) {
                $measuregrp_object = new measuregrp_object();
                $measuregrp_object->loadApiObject($measuregrpsApi);
                $measuregrp_object->link('inlineResponse2002Body', $this);
                $measuregrp_object->save();
            }
        }

        return $saved;
    }
    */
}
