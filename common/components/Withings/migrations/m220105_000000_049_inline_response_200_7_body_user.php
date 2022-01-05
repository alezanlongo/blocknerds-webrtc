<?php

/**
 * Table for inline_response_200_7_body_user
 */
class m220105_000000_049_inline_response_200_7_body_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_7_body_users}}', [
            'code' => $this->string(),
            'external_id' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_7_body_users}}');
    }
}
