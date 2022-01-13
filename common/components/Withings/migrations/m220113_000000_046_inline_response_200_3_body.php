<?php

/**
 * Table for inline_response_200_3_body
 */
class m220113_000000_046_inline_response_200_3_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_3_bodies}}', [
            'appli' => $this->integer(),
            'callbackurl' => $this->string(),
            'comment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_3_bodies}}');
    }
}
