<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $code Diagnosis code
 * @property string $codeset Diagnosis codeset (SNOMED, ICD9, ICD10, etc)
 * @property string $name Diagnosis name. Might be different than problem name.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Diagnose extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%diagnoses}}';
    }

    public function rules()
    {
        return [
            [['code', 'codeset', 'name'], 'trim'],
            [['code', 'codeset', 'name'], 'string'],
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
        if($name = ArrayHelper::getValue($apiObject, 'name')) {
            $this->name = $name;
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
