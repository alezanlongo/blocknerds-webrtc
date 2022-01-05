<?php

/**
 * Table for inline_response_200_21_body
 */
class m220105_000000_074_inline_response_200_21_body extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_21_bodies}}', [
            'goals_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-goals-goals_id',
            '{{%inline_response_200_21_bodies}}',
            'goals_id',
            'goals',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_21_bodies}}');
    }
}
