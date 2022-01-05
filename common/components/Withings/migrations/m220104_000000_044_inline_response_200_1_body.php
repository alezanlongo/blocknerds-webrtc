<?php

/**
 * Table for inline_response_200_1_body
 */
class m220104_000000_044_inline_response_200_1_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_1_bodies}}', [
            'user_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-user-user_id',
            '{{%inline_response_200_1_bodies}}',
            'user_id',
            'users',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_1_bodies}}');
    }
}
