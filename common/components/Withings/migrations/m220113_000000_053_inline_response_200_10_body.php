<?php

/**
 * Table for inline_response_200_10_body
 */
class m220113_000000_053_inline_response_200_10_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_10_bodies}}', [
            'signal' => $this->string(),
            'sampling_frequency' => $this->integer(),
            'wearposition' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_10_bodies}}');
    }
}
