<?php

/**
 * Table for AdminDocumentPageDetail
 */
class m211129_000000_102_AdminDocumentPageDetail extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%admin_document_page_details}}', [
            'adminDocument_id' => $this->integer(),
            'contenttype' => $this->string(),
            'href' => $this->string(),
            'pageid' => $this->string(),
            'pageordering' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-adminDocument-adminDocument_id',
            '{{%admin_document_page_details}}',
            'adminDocument_id',
            'admin_documents',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%admin_document_page_details}}');
    }
}
