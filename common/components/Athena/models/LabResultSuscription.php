<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $eventname Name of event
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class LabResultSuscription extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%lab_result_suscriptions}}';
    }

    public function rules()
    {
        return [
            [['eventname'], 'trim'],
            [['eventname'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($eventname = ArrayHelper::getValue($apiObject, 'eventname')) {
            $this->eventname = $eventname;
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