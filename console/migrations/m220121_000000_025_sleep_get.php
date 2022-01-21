<?php

/**
 * Table for sleep_get
 */
class m220121_000000_025_sleep_get extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_gets}}', [
            'series' => $this->string(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_gets}}');
    }
}
