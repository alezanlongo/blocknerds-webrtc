<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $class The class of the child document. E.g., LETTER, PRESCRIPTION.
 * @property int $clinicalproviderid The ID of the facility (facilityid), person, or group that the child document was received from (results, prescription changes/authorizations) or is being sent to (new prescriptions, etc).
 * @property int $documentid The ID of the child document.
 * @property string $status The status of the child document.
 * @property string $subclass The subclass of the child document.. E.g., LETTER_SUMMARYCARERECORD, PRESCRIPTION_RENEWAL.
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class Document extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%documents}}';
    }

    public function rules()
    {
        return [
            [['class', 'status', 'subclass'], 'trim'],
            [['class', 'status', 'subclass'], 'string'],
            [['clinicalproviderid', 'documentid', 'externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($class = ArrayHelper::getValue($apiObject, 'class')) {
            $this->class = $class;
        }
        if($clinicalproviderid = ArrayHelper::getValue($apiObject, 'clinicalproviderid')) {
            $this->clinicalproviderid = $clinicalproviderid;
        }
        if($documentid = ArrayHelper::getValue($apiObject, 'documentid')) {
            $this->documentid = $documentid;
        }
        if($status = ArrayHelper::getValue($apiObject, 'status')) {
            $this->status = $status;
        }
        if($subclass = ArrayHelper::getValue($apiObject, 'subclass')) {
            $this->subclass = $subclass;
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
