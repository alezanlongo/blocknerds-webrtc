<?php

/**
 * Table for user_link
 */
class m220121_000000_030_user_link extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_links}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_links}}');
    }
}
