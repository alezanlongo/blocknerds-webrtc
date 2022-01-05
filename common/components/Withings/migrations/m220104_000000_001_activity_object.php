<?php

/**
 * Table for activity_object
 */
class m220104_000000_001_activity_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%activity_objects}}', [
            'date' => $this->string(),
            'timezone' => $this->string(),
            'deviceid' => $this->string(),
            'hash_deviceid' => $this->string(),
            'brand' => $this->integer(),
            'is_tracker' => $this->boolean(),
            'steps' => $this->integer(),
            'distance' => $this->float(),
            'elevation' => $this->float(),
            'soft' => $this->integer(),
            'moderate' => $this->integer(),
            'intense' => $this->integer(),
            'active' => $this->integer(),
            'calories' => $this->float(),
            'totalcalories' => $this->float(),
            'hr_average' => $this->integer(),
            'hr_min' => $this->integer(),
            'hr_max' => $this->integer(),
            'hr_zone_0' => $this->integer(),
            'hr_zone_1' => $this->integer(),
            'hr_zone_2' => $this->integer(),
            'hr_zone_3' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%activity_objects}}');
    }
}
