<?php

/**
 * Table for inline_response_200_13_body_series_timestamp
 */
class m220105_000000_056_inline_response_200_13_body_series_timestamp extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%inline_response_200_13_body_series_timestamps}}', [
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
        $this->dropTable('{{%inline_response_200_13_body_series_timestamps}}');
    }
}
