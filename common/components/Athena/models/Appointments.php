<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
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

        $this->appointmentids = ArrayHelper::getValue($apiObject, 'appointmentids');
        $this->id = ArrayHelper::getValue($apiObject, 'id');

        return $this;
    }
    
    public static function createFromApiObject($apiObject) {
        $model = new self();

        return $model->loadApiObject($apiObject);
    }
}
