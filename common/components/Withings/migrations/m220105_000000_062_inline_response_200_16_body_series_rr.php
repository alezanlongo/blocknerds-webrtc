<?php

/**
 * Table for inline_response_200_16_body_series_rr
 */
class m220105_000000_062_inline_response_200_16_body_series_rr extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_16_body_series_rrs}}', [
            '$timestamp' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_16_body_series_rrs}}');
    }
}
