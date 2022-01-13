<?php

/**
 * Table for inline_response_200_body
 */
class m220113_000000_042_inline_response_200_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_bodies}}', [
            'userid' => $this->string(),
            'access_token' => $this->string(),
            'refresh_token' => $this->string(),
            'expires_in' => $this->integer(),
            'scope' => $this->string(),
            'csrf_token' => $this->string(),
            'token_type' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_bodies}}');
    }
}
