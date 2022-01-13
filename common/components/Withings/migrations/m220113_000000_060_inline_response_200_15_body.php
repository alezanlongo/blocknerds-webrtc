<?php

/**
 * Table for inline_response_200_15_body
 */
class m220113_000000_060_inline_response_200_15_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_15_bodies}}', [
            'nonce' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_15_bodies}}');
    }
}
