<?php

/**
 * Table for inline_response_200_19_body
 */
class m220113_000000_070_inline_response_200_19_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_19_bodies}}', [
            'user_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%inline_response_200_19_bodies}}',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_19_bodies}}');
    }
}
