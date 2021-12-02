<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $frequency dosage frequency
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Frequency extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%frequencies}}';
    }

    public function rules()
    {
        return [
            [['frequency'], 'trim'],
            [['frequency'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($frequency = ArrayHelper::getValue($apiObject, 'frequency')) {
            $this->frequency = $frequency;
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
