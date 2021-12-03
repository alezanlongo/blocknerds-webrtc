<?php

namespace common\components\Athena\apiModels;

use Yii;
use common\models\ApiModel as BaseApiModel;

/**
 * 
 *
 * @property AdminDocument $adminDocument
 * @property string $contenttype The content-type that will be returned by the page image call.
 * @property string $href The URL to get the document image.
 * @property string $pageid The ID to use in a call to get the page image.
 * @property string $pageordering Within this list of pages, the ordering (starting with 1).
 */
class AdminDocumentPageDetailApi extends BaseApiModel
{

    public $adminDocument;
    public $contenttype;
    public $href;
    public $pageid;
    public $pageordering;

    public function rules()
    {
        return [
            [['contenttype', 'href', 'pageid', 'pageordering'], 'trim'],
            [['contenttype', 'href', 'pageid', 'pageordering'], 'string'],
        ];
    }
    public function init()
    {
        parent::init();
    }

}
