<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $errormessage If there was an error with this call and SUCCESS is set to false, this field may provide additional information.
 * @property string $newdocumentid The document ID of newly created document as a result of action of Deny-New Prescription To Follow (DNTF).
 * @property string $success Returns true if the update was a success.
 * @property string $versiontoken A token representing the current state of this document. Will only be set if VERSIONTOKEN was originally sent to the endpoint.
 */
class PostActionNote200ResponseApi extends BaseApiModel
{

    public $errormessage;
    public $newdocumentid;
    public $success;
    public $versiontoken;

    public function rules()
    {
        return [
            [['errormessage', 'newdocumentid', 'success', 'versiontoken'], 'trim'],
            [['errormessage', 'newdocumentid', 'success', 'versiontoken'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
