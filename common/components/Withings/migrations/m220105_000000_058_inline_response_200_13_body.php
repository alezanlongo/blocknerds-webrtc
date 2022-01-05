<?php

/**
 * Table for inline_response_200_13_body
 */
class m220105_000000_058_inline_response_200_13_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_13_bodies}}', [
            'series_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-series-series_id',
            '{{%inline_response_200_13_bodies}}',
            'series_id',
            'series',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_13_bodies}}');
    }
}
