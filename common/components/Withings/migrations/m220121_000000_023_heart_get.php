<?php

/**
 * Table for heart_get
 */
class m220121_000000_023_heart_get extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_heart_gets}}', [
            'signal' => $this->string(),
            'sampling_frequency' => $this->integer(),
            'wearposition' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_heart_gets}}');
    }
}
