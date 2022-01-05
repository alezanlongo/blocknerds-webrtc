<?php

/**
 * Table for workout_object_data
 */
class m220105_000000_039_workout_object_data extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%workout_object_datas}}', [
            'algo_pause_duration' => $this->integer(),
            'calories' => $this->integer(),
            'distance' => $this->integer(),
            'elevation' => $this->integer(),
            'hr_average' => $this->integer(),
            'hr_max' => $this->integer(),
            'hr_min' => $this->integer(),
            'hr_zone_0' => $this->integer(),
            'hr_zone_1' => $this->integer(),
            'hr_zone_2' => $this->integer(),
            'hr_zone_3' => $this->integer(),
            'intensity' => $this->integer(),
            'manual_calories' => $this->integer(),
            'manual_distance' => $this->integer(),
            'pause_duration' => $this->integer(),
            'pool_laps' => $this->integer(),
            'pool_length' => $this->integer(),
            'spo2_average' => $this->integer(),
            'steps' => $this->integer(),
            'strokes' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%workout_object_datas}}');
    }
}
