<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 * Response data. *
 * @property notify_object[] $profiles List of notification configurations for this user.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class inline_response_200_4_body extends \yii\db\ActiveRecord
{
 
    protected $_profilesAr;

    public static function tableName()
    {
        return '{{%inline_response_200_4_bodies}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getProfiles()
    {
        return $this->hasMany(notify_object::class, ['inline_response_200_4_body_id' => 'id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($profiles = ArrayHelper::getValue($apiObject, 'profiles')) {
            $this->_profilesAr = $profiles;
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
        if( !empty($this->_profilesAr) and is_array($this->_profilesAr) ) {
            foreach($this->_profilesAr as $profilesApi) {
                $notify_object = new notify_object();
                $notify_object->loadApiObject($profilesApi);
                $notify_object->link('inlineResponse2004Body', $this);
                $notify_object->save();
            }
        }

        return $saved;
    }
    */
}
