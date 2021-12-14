<?php

/**
 * Table for PutAdminDocument
 */
class m211214_000000_122_PutAdminDocument extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_admin_documents}}', [
            'adminid' => $this->integer(),
            'documentdate' => $this->string(),
            'documenttypeid' => $this->integer(),
            'internalnote' => $this->string(),
            'priority' => $this->string(),
            'providerid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_admin_documents}}');
    }
}
