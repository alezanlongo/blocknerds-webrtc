<?php

/**
 * Table for ClinicalDocumentPage
 */
class m211105_000000_052_ClinicalDocumentPage extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%clinical_document_pages}}', [
            'attachment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%clinical_document_pages}}');
    }
}
