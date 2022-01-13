<?php

/**
 * Table for inline_response_200_8_body
 */
class m220113_000000_051_inline_response_200_8_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_8_bodies}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_8_bodies}}');
    }
}
