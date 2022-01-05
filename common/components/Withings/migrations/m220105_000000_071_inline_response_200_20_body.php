<?php

/**
 * Table for inline_response_200_20_body
 */
class m220105_000000_071_inline_response_200_20_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_20_bodies}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_20_bodies}}');
    }
}
