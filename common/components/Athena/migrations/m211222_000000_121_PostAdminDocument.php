<?php

/**
 * Table for PostAdminDocument
 */
class m211222_000000_121_PostAdminDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_admin_documents}}', [
            'attachmentcontents' => $this->string(),
            'attachmenttype' => $this->string(),
            'autoclose' => $this->boolean(),
            'departmentid' => $this->integer()->notNull(),
            'documentdata' => $this->string(),
            'documentdate' => $this->string(),
            'documentsubclass' => $this->string()->notNull(),
            'documenttypeid' => $this->integer(),
            'entityid' => $this->string(),
            'entitytype' => $this->string(),
            'internalnote' => $this->string(),
            'originalfilename' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_admin_documents}}');
    }
}
