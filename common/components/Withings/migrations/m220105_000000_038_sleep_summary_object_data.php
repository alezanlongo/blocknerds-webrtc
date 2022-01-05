<?php

/**
 * Table for sleep_summary_object_data
 */
class m220105_000000_038_sleep_summary_object_data extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%sleep_summary_object_datas}}', [
            'apnea_hypopnea_index' => $this->integer(),
            'asleepduration' => $this->integer(),
            'breathing_disturbances_intensity' => $this->integer(),
            'deepsleepduration' => $this->integer(),
            'durationtosleep' => $this->integer(),
            'durationtowakeup' => $this->integer(),
            'hr_average' => $this->integer(),
            'hr_max' => $this->integer(),
            'hr_min' => $this->integer(),
            'lightsleepduration' => $this->integer(),
            'nb_rem_episodes' => $this->integer(),
            'night_events' => $this->string(),
            'out_of_bed_count' => $this->integer(),
            'remsleepduration' => $this->integer(),
            'rr_average' => $this->integer(),
            'rr_max' => $this->integer(),
            'rr_min' => $this->integer(),
            'sleep_efficiency' => $this->float(),
            'sleep_latency' => $this->integer(),
            'sleep_score' => $this->integer(),
            'snoring' => $this->integer(),
            'snoringepisodecount' => $this->integer(),
            'total_sleep_time' => $this->integer(),
            'total_timeinbed' => $this->integer(),
            'wakeup_latency' => $this->integer(),
            'wakeupcount' => $this->integer(),
            'wakeupduration' => $this->integer(),
            'waso' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%sleep_summary_object_datas}}');
    }
}
