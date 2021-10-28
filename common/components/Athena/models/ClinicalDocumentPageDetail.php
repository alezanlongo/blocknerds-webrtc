<?php
namespace common\components\Athena\models;

use yii\helpers\ArrayHelper;

/**
 *  *
 * @property string $contenttype The content-type that will be returned by the page image call.
 * @property string $href The URL to get the document image.
 * @property string $pageid The ID to use in a call to get the page image.
 * @property string $pageordering Within this list of pages, the ordering (starting with 1).
 * @property integer $externalId API Primary Key
 * @property integer $id Primary Key
 */
class ClinicalDocumentPageDetail extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%clinical_document_page_details}}';
    }

    public function rules()
    {
        return [
            [['contenttype', 'href', 'pageid', 'pageordering'], 'trim'],
            [['contenttype', 'href', 'pageid', 'pageordering'], 'string'],
            [['externalId', 'id'], 'integer'],
        ];
    }


    public function loadApiObject($apiObject) {
        if(empty($apiObject))
            return null;

        if($contenttype = ArrayHelper::getValue($apiObject, 'contenttype')) {
            $this->contenttype = $contenttype;
        }
        if($href = ArrayHelper::getValue($apiObject, 'href')) {
            $this->href = $href;
        }
        if($pageid = ArrayHelper::getValue($apiObject, 'pageid')) {
            $this->pageid = $pageid;
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
