<?php

/**
 * Table for sleep_get_series_snoring
 */
class m220203_000000_009_sleep_get_series_snoring extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_get_series_snorings}}', [
            'timestamp' => $this->integer(),
            'value' => $this->integer(),
            'sleep_get_series_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-sleep_get_series-sleep_get_series_id',
            '{{%wth_sleep_get_series_snorings}}',
            'sleep_get_series_id',
            'wth_sleep_get_series',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_get_series_snorings}}');
    }
}
