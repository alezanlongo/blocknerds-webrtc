<?php

/**
 * Table for inline_response_200_2_body
 */
class m220104_000000_045_inline_response_200_2_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_2_bodies}}', [
            'updatetime' => $this->string(),
            'timezone' => $this->string(),
            'more' => $this->integer(),
            'offset' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_2_bodies}}');
    }
}
