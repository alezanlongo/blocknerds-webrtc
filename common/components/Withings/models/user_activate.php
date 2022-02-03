<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property integer $user_id
 * @property dropshipment_user $user
 * @property user_device_mac_object[] $devices
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class user_activate extends \yii\db\ActiveRecord
{
 
    protected $_devicesAr;

    public static function tableName()
    {
        return '{{%wth_user_activates}}';
    }

    public function rules()
    {
        return [
            [['user_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getUser()
    {
        return $this->hasOne(dropshipment_user::class, ['id' => 'user_id']);
    }

    public function getDevices()
    {
        return $this->hasMany(user_device_mac_object::class, ['user_activate_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($user_id = ArrayHelper::getValue($apiObject, 'user_id')) {
            $this->user_id = $user_id;
        }
        if($user = ArrayHelper::getValue($apiObject, 'user')) {
            $this->user = $user;
        }
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
                $user_device_mac_object->link('userActivate', $this);
                $user_device_mac_object->save();
            }
        }

        return $saved;
    }
    */
}