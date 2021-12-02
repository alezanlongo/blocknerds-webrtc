<?php

/**
 * Table for ClinicalDocumentPageDetail
 */
class m211202_000000_086_ClinicalDocumentPageDetail extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_document_page_details}}', [
            'clinicalDocument_id' => $this->integer(),
            'labResult_id' => $this->integer(),
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
        $this->addForeignKey(
            'fk-labResult-labResult_id',
            '{{%clinical_document_page_details}}',
            'labResult_id',
            'lab_results',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%clinical_document_page_details}}');
    }
}
