<?php

/**
 * Table for measure_getintradayactivity
 */
class m220121_000000_024_measure_getintradayactivity extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_measure_getintradayactivities}}', [
            'series' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_measure_getintradayactivities}}');
    }
}
