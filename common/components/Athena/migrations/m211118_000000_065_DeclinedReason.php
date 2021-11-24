<?php

/**
 * Table for DeclinedReason
 */
class m211118_000000_065_DeclinedReason extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%declined_reasons}}', [
            'code' => $this->string(),
            'codeset' => $this->string(),
            'description' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%declined_reasons}}');
    }
}
