<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $code The code indicating why the order was contraindicated.
 * @property string $codeset The codeset that the code belongs to.
 * @property string $description The plaintext description of the contraindication reason.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ContraindicationReason extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%contraindication_reasons}}';
    }

    public function rules()
    {
        return [
            [['code', 'codeset', 'description'], 'trim'],
            [['code', 'codeset', 'description'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($code = ArrayHelper::getValue($apiObject, 'code')) {
            $this->code = $code;
        }
        if($codeset = ArrayHelper::getValue($apiObject, 'codeset')) {
            $this->codeset = $codeset;
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
