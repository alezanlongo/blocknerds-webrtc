<?php

/**
 * Table for inline_response_200_5
 */
class m220105_000000_020_inline_response_200_5 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_5s}}', [
            'status' => $this->integer(),
            'body' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_5s}}');
    }
}
