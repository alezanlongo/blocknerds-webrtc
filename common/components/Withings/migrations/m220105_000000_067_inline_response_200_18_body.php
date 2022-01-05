<?php

/**
 * Table for inline_response_200_18_body
 */
class m220105_000000_067_inline_response_200_18_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_18_bodies}}', [
            'user_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%inline_response_200_18_bodies}}',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_18_bodies}}');
    }
}
