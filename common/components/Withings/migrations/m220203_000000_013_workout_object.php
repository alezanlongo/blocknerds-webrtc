<?php

/**
 * Table for workout_object
 */
class m220203_000000_013_workout_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_workout_objects}}', [
            'profile_id' => $this->integer(),
            'category' => $this->integer(),
            'timezone' => $this->string(),
            'model' => $this->integer(),
            'attrib' => $this->integer(),
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'date' => $this->string(),
            'modified' => $this->integer(),
            'deviceid' => $this->string(),
            'workout_object_data__algo_pause_duration' => $this->integer(),
            'workout_object_data__calories' => $this->integer(),
            'workout_object_data__distance' => $this->integer(),
            'workout_object_data__elevation' => $this->integer(),
            'workout_object_data__hr_average' => $this->integer(),
            'workout_object_data__hr_max' => $this->integer(),
            'workout_object_data__hr_min' => $this->integer(),
            'workout_object_data__hr_zone_0' => $this->integer(),
            'workout_object_data__hr_zone_1' => $this->integer(),
            'workout_object_data__hr_zone_2' => $this->integer(),
            'workout_object_data__hr_zone_3' => $this->integer(),
            'workout_object_data__intensity' => $this->integer(),
            'workout_object_data__manual_calories' => $this->integer(),
            'workout_object_data__manual_distance' => $this->integer(),
            'workout_object_data__pause_duration' => $this->integer(),
            'workout_object_data__pool_laps' => $this->integer(),
            'workout_object_data__pool_length' => $this->integer(),
            'workout_object_data__spo2_average' => $this->integer(),
            'workout_object_data__steps' => $this->integer(),
            'workout_object_data__strokes' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_workout_objects}}');
    }
}
