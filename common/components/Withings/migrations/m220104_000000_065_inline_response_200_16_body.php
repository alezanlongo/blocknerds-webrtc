<?php

/**
 * Table for inline_response_200_16_body
 */
class m220104_000000_065_inline_response_200_16_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_16_bodies}}', [
            'series_id' => $this->integer(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-series-series_id',
            '{{%inline_response_200_16_bodies}}',
            'series_id',
            'series',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_16_bodies}}');
    }
}
