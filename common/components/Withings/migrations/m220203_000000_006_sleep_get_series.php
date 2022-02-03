<?php

/**
 * Table for sleep_get_series
 */
class m220203_000000_006_sleep_get_series extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_get_series}}', [
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'state' => $this->integer(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'hash_deviceid' => $this->integer(),
            'sleep_get_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-sleep_get-sleep_get_id',
            '{{%wth_sleep_get_series}}',
            'sleep_get_id',
            'wth_sleep_gets',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_get_series}}');
    }
}
