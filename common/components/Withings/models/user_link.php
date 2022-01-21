<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property user_device_mac_object[] $devices
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class user_link extends \yii\db\ActiveRecord
{
 
    protected $_devicesAr;

    public static function tableName()
    {
        return '{{%wth_user_links}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getDevices()
    {
        return $this->hasMany(user_device_mac_object::class, ['user_link_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($devices = ArrayHelper::getValue($apiObject, 'devices')) {
            $this->_devicesAr = $devices;
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
        if( !empty($this->_devicesAr) and is_array($this->_devicesAr) ) {
            foreach($this->_devicesAr as $devicesApi) {
                $user_device_mac_object = new user_device_mac_object();
                $user_device_mac_object->loadApiObject($devicesApi);
                $user_device_mac_object->link('userLink', $this);
                $user_device_mac_object->save();
            }
        }

        return $saved;
    }
    */
}
