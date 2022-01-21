<?php

/**
 * Table for user_get
 */
class m220121_000000_027_user_get extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_gets}}', [
            'user' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_gets}}');
    }
}
