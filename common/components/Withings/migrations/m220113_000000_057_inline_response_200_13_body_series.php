<?php

/**
 * Table for inline_response_200_13_body_series
 */
class m220113_000000_057_inline_response_200_13_body_series extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_13_body_series}}', [
            '$timestamp_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-$timestamp-$timestamp_id',
            '{{%inline_response_200_13_body_series}}',
            '$timestamp_id',
            '$timestamps',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_13_body_series}}');
    }
}
