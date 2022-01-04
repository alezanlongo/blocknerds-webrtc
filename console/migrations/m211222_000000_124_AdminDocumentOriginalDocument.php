<?php

/**
 * Table for AdminDocumentOriginalDocument
 */
class m211222_000000_124_AdminDocumentOriginalDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%admin_document_original_documents}}', [
            'attachment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%admin_document_original_documents}}');
    }
}
