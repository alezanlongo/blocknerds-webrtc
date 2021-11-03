<?php

/**
 * Table for CloseReason
 */
class m211022_000000_036_CloseReason extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%close_reasons}}', [
            'reason' => $this->string(),
            'reasonid' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%close_reasons}}');
    }
}