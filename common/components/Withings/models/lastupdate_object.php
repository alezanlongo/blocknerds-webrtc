<?php
namespace common\components\Withings\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $measure Most recent modified date of user measures
 * @property int $externalId Id of the user
 * @property integer $id Primary Key
 */
class lastupdate_object extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%wth_lastupdate_objects}}';
    }

    public function rules()
    {
        return [
            [['measure', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($measure = ArrayHelper::getValue($apiObject, 'measure')) {
            $this->measure = $measure;
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

        return $saved;
    }
    */
}
