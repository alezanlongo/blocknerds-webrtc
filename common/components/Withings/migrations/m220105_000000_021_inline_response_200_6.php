<?php

/**
 * Table for inline_response_200_6
 */
class m220105_000000_021_inline_response_200_6 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_6s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200_6s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_6s}}');
    }
}
