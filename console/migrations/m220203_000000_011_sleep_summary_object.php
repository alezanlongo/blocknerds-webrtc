<?php

/**
 * Table for sleep_summary_object
 */
class m220203_000000_011_sleep_summary_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_summary_objects}}', [
            'profile_id' => $this->integer(),
            'timezone' => $this->string(),
            'model' => $this->integer(),
            'model_id' => $this->integer(),
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'date' => $this->string(),
            'created' => $this->integer(),
            'modified' => $this->integer(),
            'sleep_summary_object_data__apnea_hypopnea_index' => $this->integer(),
            'sleep_summary_object_data__asleepduration' => $this->integer(),
            'sleep_summary_object_data__breathing_disturbances_intensity' => $this->integer(),
            'sleep_summary_object_data__deepsleepduration' => $this->integer(),
            'sleep_summary_object_data__durationtosleep' => $this->integer(),
            'sleep_summary_object_data__durationtowakeup' => $this->integer(),
            'sleep_summary_object_data__hr_average' => $this->integer(),
            'sleep_summary_object_data__hr_max' => $this->integer(),
            'sleep_summary_object_data__hr_min' => $this->integer(),
            'sleep_summary_object_data__lightsleepduration' => $this->integer(),
            'sleep_summary_object_data__nb_rem_episodes' => $this->integer(),
            'sleep_summary_object_data__night_events' => $this->string(),
            'sleep_summary_object_data__out_of_bed_count' => $this->integer(),
            'sleep_summary_object_data__remsleepduration' => $this->integer(),
            'sleep_summary_object_data__rr_average' => $this->integer(),
            'sleep_summary_object_data__rr_max' => $this->integer(),
            'sleep_summary_object_data__rr_min' => $this->integer(),
            'sleep_summary_object_data__sleep_efficiency' => $this->float(),
            'sleep_summary_object_data__sleep_latency' => $this->integer(),
            'sleep_summary_object_data__sleep_score' => $this->integer(),
            'sleep_summary_object_data__snoring' => $this->integer(),
            'sleep_summary_object_data__snoringepisodecount' => $this->integer(),
            'sleep_summary_object_data__total_sleep_time' => $this->integer(),
            'sleep_summary_object_data__total_timeinbed' => $this->integer(),
            'sleep_summary_object_data__wakeup_latency' => $this->integer(),
            'sleep_summary_object_data__wakeupcount' => $this->integer(),
            'sleep_summary_object_data__wakeupduration' => $this->integer(),
            'sleep_summary_object_data__waso' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_summary_objects}}');
    }
}
