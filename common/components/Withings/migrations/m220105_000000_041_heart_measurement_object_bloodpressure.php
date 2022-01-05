<?php

/**
 * Table for heart_measurement_object_bloodpressure
 */
class m220105_000000_041_heart_measurement_object_bloodpressure extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%heart_measurement_object_bloodpressures}}', [
            'diastole' => $this->integer(),
            'systole' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%heart_measurement_object_bloodpressures}}');
    }
}
