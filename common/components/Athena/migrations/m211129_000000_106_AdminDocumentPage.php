<?php

/**
 * Table for AdminDocumentPage
 */
class m211129_000000_106_AdminDocumentPage extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%admin_document_pages}}', [
            'attachment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%admin_document_pages}}');
    }
}
