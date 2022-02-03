<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $profile_id
 * @property int $grpid Id of the measure group.
 * @property int $attrib The way the measure was attributed to the user:
 * 
 * 
 * | Value | Description|
 * |---|---|
 * |0 | The measuregroup has been captured by a device and is known to belong to this user (and is not ambiguous)|
 * |1 | The measuregroup has been captured by a device but may belong to other users as well as this one (it is ambiguous)|
 * |2 | The measuregroup has been entered manually for this particular user|
 * |4 | The measuregroup has been entered manually during user creation (and may not be accurate)|
 * |5 | Measure auto, it's only for the Blood Pressure Monitor. This device can make many measures and computed the best value|
 * |7 | Measure confirmed. You can get this value if the user confirmed a detected activity|
 * |8 | Same as attrib 0|
 * @property int $date UNIX timestamp when measures were taken.
 * @property int $created UNIX timestamp when measures were stored.
 * @property int $category Category for the measures in the group (see category input parameter).
 * @property string $deviceid ID of device that tracked the data. To retrieve information about this device, refer to : <a href='/api-reference/#operation/userv2-getdevice'>User v2 - Getdevice</a>.
 * @property measure_object[] $measures List of measures in the group.
 * @property string $comment Deprecated. This property will always be empty.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class measuregrp_object extends \yii\db\ActiveRecord
{
 
    protected $_measuresAr;

    public static function tableName()
    {
        return '{{%wth_measuregrp_objects}}';
    }

    public function rules()
    {
        return [
            [['deviceid', 'comment'], 'trim'],
            [['deviceid', 'comment'], 'string'],
            [['profile_id', 'grpid', 'attrib', 'date', 'created', 'category', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getMeasures()
    {
        return $this->hasMany(measure_object::class, ['measuregrp_object_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profile_id = ArrayHelper::getValue($apiObject, 'profile_id')) {
            $this->profile_id = $profile_id;
        }
        if($grpid = ArrayHelper::getValue($apiObject, 'grpid')) {
            $this->grpid = $grpid;
        }
        if($attrib = ArrayHelper::getValue($apiObject, 'attrib')) {
            $this->attrib = $attrib;
        }
        if($date = ArrayHelper::getValue($apiObject, 'date')) {
            $this->date = $date;
        }
        if($created = ArrayHelper::getValue($apiObject, 'created')) {
            $this->created = $created;
        }
        if($category = ArrayHelper::getValue($apiObject, 'category')) {
            $this->category = $category;
        }
        if($deviceid = ArrayHelper::getValue($apiObject, 'deviceid')) {
            $this->deviceid = $deviceid;
        }
        if($measures = ArrayHelper::getValue($apiObject, 'measures')) {
            $this->_measuresAr = $measures;
        }
        if($comment = ArrayHelper::getValue($apiObject, 'comment')) {
            $this->comment = $comment;
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
        if( !empty($this->_measuresAr) and is_array($this->_measuresAr) ) {
            foreach($this->_measuresAr as $measuresApi) {
                $measure_object = new measure_object();
                $measure_object->loadApiObject($measuresApi);
                $measure_object->link('measuregrpObject', $this);
                $measure_object->save();
            }
        }

        return $saved;
    }
    */
}
