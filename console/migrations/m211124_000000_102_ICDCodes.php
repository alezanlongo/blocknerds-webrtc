<?php

/**
 * Table for ICDCodes
 */
class m211124_000000_102_ICDCodes extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%icdcodes}}', [
            'code' => $this->string(),
            'codeset' => $this->string(),
            'description' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%icdcodes}}');
    }
}