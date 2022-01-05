<?php

/**
 * Table for inline_response_200_21_body_goals_weight
 */
class m220105_000000_072_inline_response_200_21_body_goals_weight extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_21_body_goals_weights}}', [
            'value' => $this->integer(),
            'unit' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%inline_response_200_21_body_goals_weights}}');
    }
}
