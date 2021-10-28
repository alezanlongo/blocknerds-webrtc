<?php

/**
 * Table for ClinicalDocumentPageDetail
 */
class m211027_000000_034_ClinicalDocumentPageDetail extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_document_page_details}}', [
            'contenttype' => $this->string(),
            'href' => $this->string(),
            'pageid' => $this->string(),
            'pageordering' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%clinical_document_page_details}}');
    }
}
