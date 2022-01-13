<?php

/**
 * Table for heart_measurement_object_ecg
 */
class m220113_000000_040_heart_measurement_object_ecg extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%heart_measurement_object_ecgs}}', [
            'signalid' => $this->integer(),
            'afib' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%heart_measurement_object_ecgs}}');
    }
}
