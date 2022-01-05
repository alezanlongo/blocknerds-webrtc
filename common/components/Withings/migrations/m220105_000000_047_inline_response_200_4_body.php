<?php

/**
 * Table for inline_response_200_4_body
 */
class m220105_000000_047_inline_response_200_4_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_4_bodies}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_4_bodies}}');
    }
}
