<?php

/**
 * Table for inline_response_200_22_body
 */
class m220113_000000_075_inline_response_200_22_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_22_bodies}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_22_bodies}}');
    }
}
