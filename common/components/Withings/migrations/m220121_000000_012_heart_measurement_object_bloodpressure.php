<?php

/**
 * Table for heart_measurement_object_bloodpressure
 */
class m220121_000000_012_heart_measurement_object_bloodpressure extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_heart_measurement_object_bloodpressures}}', [
            'diastole' => $this->integer(),
            'systole' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_heart_measurement_object_bloodpressures}}');
    }
}
