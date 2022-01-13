<?php

/**
 * Table for inline_response_200_16_body_series_snoring
 */
class m220113_000000_063_inline_response_200_16_body_series_snoring extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_16_body_series_snorings}}', [
            '$timestamp' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_16_body_series_snorings}}');
    }
}
