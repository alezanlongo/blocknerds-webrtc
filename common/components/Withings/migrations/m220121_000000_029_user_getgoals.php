<?php

/**
 * Table for user_getgoals
 */
class m220121_000000_029_user_getgoals extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_getgoals}}', [
            'goals' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_getgoals}}');
    }
}
