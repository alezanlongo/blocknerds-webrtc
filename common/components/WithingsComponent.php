<?php

namespace common\components;

use Yii;
use yii\base\Component;
use yii\helpers\VarDumper;
use common\components\Withings\WithingsClient;
use common\components\Withings\models\sleep_get;
use common\components\Withings\models\measure_object;
use common\components\Withings\models\workout_object;
use common\components\Withings\models\activity_object;
use common\components\Withings\models\sleep_get_series;
use common\components\Withings\models\measuregrp_object;
use common\components\Withings\models\sleep_get_series_hr;
use common\components\Withings\models\sleep_get_series_rr;
use common\components\Withings\models\workout_object_data;
use common\components\Withings\models\sleep_get_series_snoring;
use common\components\Withings\models\measure_getintradayactivity;
use common\components\Withings\models\sleep_summary_object;

class WithingsComponent extends Component
{
    private $client;

    public function __construct(WithingsClient $client)
    {
        $this->client = $client;
    }

    public function measureGetmeas()
    {
        $measuresApi = $this->client->measureGetmeas([
            'action' => 'getmeas',
            'startdate' => 1593572400,
            'enddate' => 1593658800
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi) && count($measuresApi) > 0) {

            foreach ($measuresApi as $value) {

                $exist = measuregrp_object::find()->where([
                    'profile_id' => $profile_id,
                    'grpid' => $value->grpid
                ])->one();

                if (!$exist) {
                    $measureGrp = measuregrp_object::createFromApiObject($value);
                    $measureGrp->profile_id = $profile_id;
                    $measureGrp->save();

                    if (is_array($value['measures']) && count($value['measures']) > 0) {
                        foreach ($value['measures'] as $measure) {
                            $measureObj = measure_object::createFromApiObject($measure);
                            $measureObj->measuregrp_object_id = $measureGrp->id;
                            $measureObj->save();
                        }
                    }
                }
            }
        }

        return $measuresApi;
    }

    public function measurev2Getactivity()
    {
        $measuresApi = $this->client->measurev2Getactivity([
            'action' => 'getactivity',
            'startdateymd' => '2020-07-01',
            'enddateymd' => '2020-07-02',
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi) && count($measuresApi) > 0) {

            foreach ($measuresApi as $measure) {

                $exist = activity_object::find()->where([
                    'profile_id' => $profile_id,
                    'date' => $measure->date
                ])->one();

                if (!$exist) {
                    $measureObj = activity_object::createFromApiObject($measure);
                    $measureObj->profile_id = $profile_id;
                    $measureObj->save();
                }
            }
        }

        return $measuresApi;
    }

    public function measurev2Getintradayactivity()
    {
        $measuresApi = $this->client->measurev2Getintradayactivity([
            'action' => 'getintradayactivity',
            'startdate' => 1593572400,
            'enddate' => 1593658800
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi['series']) && count($measuresApi['series']) > 0) {
            foreach ($measuresApi['series'] as $measure) {

                $exist = measure_getintradayactivity::find()->where([
                    'profile_id' => $profile_id,
                    'timestamp' => $measure->timestamp
                ])->one();

                if (!$exist) {
                    $measureObj = measure_getintradayactivity::createFromApiObject($measure);
                    $measureObj->profile_id = $profile_id;
                    $measureObj->save();
                }
            }
        }

        return $measuresApi;
    }

    public function measurev2Getworkouts()
    {
        $measuresApi = $this->client->measurev2Getworkouts([
            'action' => 'getworkouts',
            'startdateymd' => '2020-07-01',
            'enddateymd' => '2020-07-02'
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi) && count($measuresApi) > 0) {

            foreach ($measuresApi as $measure) {

                $exist = workout_object::find()->where([
                    'profile_id' => $profile_id,
                    'date' => $measure->date
                ])->one();

                if (!$exist) {

                    $measureObj = workout_object::createFromApiObject($measure);
                    $measureObj->profile_id = $profile_id;
                    $measureObj->save();
                }
            }
        }

        return $measuresApi;
    }

    private function buildMeasure($id, $measure, $name)
    {
        if (!empty($measure[$name]) && is_array($measure[$name])) {

            foreach ($measure[$name] as $value) {

                switch ($name) {
                    case 'hr':
                        $hrObj = sleep_get_series_hr::createFromApiObject($value);
                        break;
                    case 'rr':
                        $hrObj = sleep_get_series_rr::createFromApiObject($value);
                        break;
                    case 'snoring':
                        $hrObj = sleep_get_series_snoring::createFromApiObject($value);
                        break;
                }

                $hrObj->sleep_get_series_id = $id;
                $hrObj->save();
            }
        }

        return false;
    }

    public function sleepv2Get()
    {
        $measuresApi = $this->client->sleepv2Get([
            'action' => 'get',
            'startdate' => 1593572400,
            'enddate' => 1593658800,
            'data_fields' => 'hr,rr,snoring'
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi['series']) && count($measuresApi['series']) > 0) {

            $exist = sleep_get::find()->where([
                'profile_id' => $profile_id,
                'model' => $measuresApi->model
            ])->one();

            if (!$exist) {
                $measureObj = sleep_get::createFromApiObject($measuresApi);
                $measureObj->profile_id = $profile_id;
                $measureObj->save();

                foreach ($measuresApi['series'] as $measure) {
                    $seriesObj = sleep_get_series::createFromApiObject($measure);
                    $seriesObj->sleep_get_id = $measureObj->id;
                    $seriesObj->save();

                    $this->buildMeasure($seriesObj->id, $measure, 'hr');
                    $this->buildMeasure($seriesObj->id, $measure, 'rr');
                    $this->buildMeasure($seriesObj->id, $measure, 'snoring');
                }
            }
        }

        return $measuresApi;
    }

    public function sleepv2Getsummary()
    {
        $measuresApi = $this->client->sleepv2Getsummary([
            'action' => 'getsummary',
            'startdateymd' => '2020-07-01',
            'enddateymd' => '2020-07-02',
            'data_fields' => 'nb_rem_episodes,sleep_efficiency,sleep_latency,total_sleep_time,total_timeinbed,wakeup_latency,waso,apnea_hypopnea_index,breathing_disturbances_intensity,asleepduration,deepsleepduration,durationtosleep,durationtowakeup,hr_average,hr_max,hr_min,lightsleepduration,night_events,out_of_bed_count,remsleepduration,rr_average,rr_max,rr_min,sleep_score,snoring,snoringepisodecount,wakeupcount,wakeupduration',
        ]);

        $profile_id = Yii::$app->user->identity->userProfile->id;

        if (is_array($measuresApi) && count($measuresApi) > 0) {

            foreach ($measuresApi as $value) {

                $exist = sleep_summary_object::find()->where([
                    'profile_id' => $profile_id,
                    'date' => $value->date
                ])->one();

                if (!$exist) {
                    $measureGrp = sleep_summary_object::createFromApiObject($value);
                    $measureGrp->profile_id = $profile_id;
                    $measureGrp->save();
                }
            }
        }

        return $measuresApi;
    }
}
