<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $class The class of the child document. E.g., LETTER, PRESCRIPTION.
 * @property int $clinicalproviderid The ID of the facility (facilityid), person, or group that the child document was received from (results, prescription changes/authorizations) or is being sent to (new prescriptions, etc).
 * @property int $documentid The ID of the child document.
 * @property string $status The status of the child document.
 * @property string $subclass The subclass of the child document.. E.g., LETTER_SUMMARYCARERECORD, PRESCRIPTION_RENEWAL.
 */
class DocumentApi extends BaseApiModel
{

    public $class;
    public $clinicalproviderid;
    public $documentid;
    public $status;
    public $subclass;

    public function rules()
    {
        return [
            [['class', 'status', 'subclass'], 'trim'],
            [['class', 'status', 'subclass'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
