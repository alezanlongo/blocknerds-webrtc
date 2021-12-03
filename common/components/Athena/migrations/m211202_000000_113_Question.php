<?php

/**
 * Table for Question
 */
class m211202_000000_113_Question extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%questions}}', [
            'answer' => $this->string(),
            'question' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%questions}}');
    }
}
