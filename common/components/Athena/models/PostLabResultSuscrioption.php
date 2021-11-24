<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property array $departmentids For every New/Update Subscriptions complete list of departmentids should be passed. NOTE: Without DepartmentIDs entire Context/Practice will be subscribed.
 * @property string $eventname By default, you are subscribed to all possible events.  If you only wish to subscribe to an individual event, pass the event name with this argument.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class PostLabResultSuscrioption extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%post_lab_result_suscrioptions}}';
    }

    public function rules()
    {
        return [
            [['eventname'], 'trim'],
            [['eventname'], 'string'],
            [['externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentids = ArrayHelper::getValue($apiObject, 'departmentids')) {
            $this->departmentids = $departmentids;
        }
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
