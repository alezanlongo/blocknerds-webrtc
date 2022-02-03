<?php

/**
 * Table for heart_measurement_object_ecg
 */
class m220203_000000_015_heart_measurement_object_ecg extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_heart_measurement_object_ecgs}}', [
            'signalid' => $this->integer(),
            'afib' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_heart_measurement_object_ecgs}}');
    }
}