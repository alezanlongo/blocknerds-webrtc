<?php

/**
 * Table for inline_response_200_17_body
 */
class m220105_000000_066_inline_response_200_17_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_17_bodies}}', [
            'more' => $this->boolean(),
            'offset' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_17_bodies}}');
    }
}
