<?php

/**
 * Table for inline_response_200_8
 */
class m220113_000000_023_inline_response_200_8 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_8s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200_8s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_8s}}');
    }
}
