<?php

/**
 * Table for sleep_get
 */
class m220203_000000_005_sleep_get extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_gets}}', [
            'profile_id' => $this->integer(),
            'model' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_gets}}');
    }
}
