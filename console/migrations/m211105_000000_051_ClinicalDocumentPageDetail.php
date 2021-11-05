<?php

/**
 * Table for ClinicalDocumentPageDetail
 */
class m211105_000000_051_ClinicalDocumentPageDetail extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_document_page_details}}', [
            'clinicalDocument_id' => $this->integer(),
            'contenttype' => $this->string(),
            'href' => $this->string(),
            'pageid' => $this->string(),
            'pageordering' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-clinicalDocument-clinicalDocument_id',
            '{{%clinical_document_page_details}}',
            'clinicalDocument_id',
            'clinical_documents',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%clinical_document_page_details}}');
    }
}
