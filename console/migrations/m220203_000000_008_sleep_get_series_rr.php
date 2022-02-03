<?php

/**
 * Table for sleep_get_series_rr
 */
class m220203_000000_008_sleep_get_series_rr extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_get_series_rrs}}', [
            'timestamp' => $this->integer(),
            'value' => $this->integer(),
            'sleep_get_series_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-sleep_get_series-sleep_get_series_id',
            '{{%wth_sleep_get_series_rrs}}',
            'sleep_get_series_id',
            'wth_sleep_get_series',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_get_series_rrs}}');
    }
}
