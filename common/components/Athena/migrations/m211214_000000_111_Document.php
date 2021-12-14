<?php

/**
 * Table for Document
 */
class m211214_000000_111_Document extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%documents}}', [
            'class' => $this->string(),
            'clinicalproviderid' => $this->integer(),
            'documentid' => $this->integer(),
            'status' => $this->string(),
            'subclass' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%documents}}');
    }
}
