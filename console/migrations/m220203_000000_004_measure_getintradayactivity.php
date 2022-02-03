<?php

/**
 * Table for measure_getintradayactivity
 */
class m220203_000000_004_measure_getintradayactivity extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_measure_getintradayactivities}}', [
            'profile_id' => $this->integer(),
            'timestamp' => $this->integer(),
            'deviceid' => $this->string(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'steps' => $this->integer(),
            'elevation' => $this->float(),
            'calories' => $this->float(),
            'distance' => $this->float(),
            'stroke' => $this->integer(),
            'pool_lap' => $this->integer(),
            'duration' => $this->integer(),
            'heart_rate' => $this->integer(),
            'spo2_auto' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_measure_getintradayactivities}}');
    }
}
