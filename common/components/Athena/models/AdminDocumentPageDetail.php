<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property integer $adminDocument_id
 * @property AdminDocument $adminDocument
 * @property string $contenttype The content-type that will be returned by the page image call.
 * @property string $href The URL to get the document image.
 * @property string $pageid The ID to use in a call to get the page image.
 * @property string $pageordering Within this list of pages, the ordering (starting with 1).
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class AdminDocumentPageDetail extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%admin_document_page_details}}';
    }

    public function rules()
    {
        return [
            [['contenttype', 'href', 'pageid', 'pageordering'], 'trim'],
            [['contenttype', 'href', 'pageid', 'pageordering'], 'string'],
            [['adminDocument_id', 'externalId', 'id'], 'integer'],
            // TODO define more concreate validation rules!
        ];
    }

    public function getAdminDocument()
    {
        return $this->hasOne(AdminDocument::class, ['id' => 'adminDocument_id']);
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($adminDocument_id = ArrayHelper::getValue($apiObject, 'adminDocument_id')) {
            $this->adminDocument_id = $adminDocument_id;
        }
        if($adminDocument = ArrayHelper::getValue($apiObject, 'adminDocument')) {
            $this->adminDocument = $adminDocument;
        }
        if($contenttype = ArrayHelper::getValue($apiObject, 'contenttype')) {
            $this->contenttype = $contenttype;
        }
        if($href = ArrayHelper::getValue($apiObject, 'href')) {
            $this->href = $href;
        }
        if($pageid = ArrayHelper::getValue($apiObject, 'pageid')) {
            $this->pageid = $pageid;
        }
        if($pageid = ArrayHelper::getValue($apiObject, 'pageid')) {
            $this->externalId = $pageid;
        }
        if($pageordering = ArrayHelper::getValue($apiObject, 'pageordering')) {
            $this->pageordering = $pageordering;
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
