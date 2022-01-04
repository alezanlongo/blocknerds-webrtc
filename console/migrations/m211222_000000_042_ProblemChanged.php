<?php

/**
 * Table for ProblemChanged
 */
class m211222_000000_042_ProblemChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%problem_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%problem_changeds}}');
    }
}
