<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property int $departmentid The department ID; needed because charts, and thus chart notes, may be department-specific
 * @property string $notetext The note text.  Use PUT to add to any existing text and POST if you want to add new or replace the full note
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class RequestChartAlert extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%request_chart_alerts}}';
    }

    public function rules()
    {
        return [
            [['notetext'], 'trim'],
            [['departmentid', 'notetext'], 'required'],
            [['notetext'], 'string'],
            [['departmentid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($departmentid = ArrayHelper::getValue($apiObject, 'departmentid')) {
            $this->departmentid = $departmentid;
        }
        if($notetext = ArrayHelper::getValue($apiObject, 'notetext')) {
            $this->notetext = $notetext;
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
