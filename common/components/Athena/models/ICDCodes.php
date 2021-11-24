<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $code Actual ICD code for this diagnosis
 * @property string $codeset Codeset for this code (ICD9 or ICD10)
 * @property string $description Brief description for this code
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ICDCodes extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%icdcodes}}';
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
