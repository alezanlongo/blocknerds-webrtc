<?php

/**
 * Table for inline_response_200_21_body_goals
 */
class m220113_000000_073_inline_response_200_21_body_goals extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_21_body_goals}}', [
            'steps' => $this->integer(),
            'sleep' => $this->integer(),
            'weight_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-weight-weight_id',
            '{{%inline_response_200_21_body_goals}}',
            'weight_id',
            'weights',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_21_body_goals}}');
    }
}
