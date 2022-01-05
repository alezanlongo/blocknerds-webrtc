<?php

/**
 * Table for inline_response_200_3
 */
class m220105_000000_018_inline_response_200_3 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_3s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200_3s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_3s}}');
    }
}
