<?php

/**
 * Table for inline_response_200_1_body_user
 */
class m220104_000000_043_inline_response_200_1_body_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_1_body_users}}', [
            'code' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_1_body_users}}');
    }
}
