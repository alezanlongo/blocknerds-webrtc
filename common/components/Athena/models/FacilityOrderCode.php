<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $code The code in the facility specific vocabulary.
 * @property string $description When available, a description of the code from the facility specific vocabulary.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class FacilityOrderCode extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%facility_order_codes}}';
    }

    public function rules()
    {
        return [
            [['code', 'description'], 'trim'],
            [['code', 'description'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($code = ArrayHelper::getValue($apiObject, 'code')) {
            $this->code = $code;
        }
        if($description = ArrayHelper::getValue($apiObject, 'description')) {
            $this->description = $description;
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
