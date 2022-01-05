<?php

/**
 * Table for inline_response_200_11_body
 */
class m220104_000000_054_inline_response_200_11_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_11_bodies}}', [
            'more' => $this->boolean(),
            'offset' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_11_bodies}}');
    }
}
