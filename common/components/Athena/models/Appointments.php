<?php

namespace common\components\Athena\models;

/**
 * 
 *
 * @property object $appointmentids An hash of appointment IDs to the time requested.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Appointments extends \yii\db\ActiveRecord
{
    public static function tableName()
    {
        return '{{%appointments}}';
    }

    public function rules()
    {
        return [
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        $this->appointmentids = ArrayHelper::getValue($obj, 'appointmentids');
        $this->id = ArrayHelper::getValue($obj, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
