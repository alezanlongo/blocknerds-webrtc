<?php

/**
 * Table for sleep_get_series_hr
 */
class m220203_000000_007_sleep_get_series_hr extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_get_series_hrs}}', [
            'timestamp' => $this->integer(),
            'value' => $this->integer(),
            'sleep_get_series_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-sleep_get_series-sleep_get_series_id',
            '{{%wth_sleep_get_series_hrs}}',
            'sleep_get_series_id',
            'wth_sleep_get_series',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_get_series_hrs}}');
    }
}
