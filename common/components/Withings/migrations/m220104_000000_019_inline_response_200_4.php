<?php

/**
 * Table for inline_response_200_4
 */
class m220104_000000_019_inline_response_200_4 extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_4s}}', [
            'status' => $this->integer(),
            'body_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-body-body_id',
            '{{%inline_response_200_4s}}',
            'body_id',
            'bodies',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_4s}}');
    }
}
