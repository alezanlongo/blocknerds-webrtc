<?php

/**
 * Table for heart_measurement_object
 */
class m220113_000000_009_heart_measurement_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%heart_measurement_objects}}', [
            'deviceid' => $this->string(),
            'model' => $this->integer(),
            'ecg_id' => $this->integer(),
            'bloodpressure_id' => $this->integer(),
            'heart_rate' => $this->integer(),
            'timestamp' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-ecg-ecg_id',
            '{{%heart_measurement_objects}}',
            'ecg_id',
            'ecgs',
            'id',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-bloodpressure-bloodpressure_id',
            '{{%heart_measurement_objects}}',
            'bloodpressure_id',
            'bloodpressures',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%heart_measurement_objects}}');
    }
}
