<?php

/**
 * Table for inline_response_200_9_body
 */
class m220113_000000_052_inline_response_200_9_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_9_bodies}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_9_bodies}}');
    }
}
