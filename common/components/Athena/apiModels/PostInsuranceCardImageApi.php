<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property string $departmentid The department ID associated with this upload.
 * @property string $image Base64 encoded image, or, if multipart/form-data, unencoded image. This image may be scaled down after submission. PUT is not recommended when using multipart/form-data. Since POST and PUT have identical functionality, POST is recommended.
 */
class PostInsuranceCardImageApi extends BaseApiModel
{

    public $departmentid;
    public $image;

    public function rules()
    {
        return [
            [['departmentid', 'image'], 'trim'],
            [['image'], 'required'],
            [['departmentid', 'image'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
