<?php

/**
 * Table for workout_object
 */
class m220121_000000_007_workout_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_workout_objects}}', [
            'category' => $this->integer(),
            'timezone' => $this->string(),
            'model' => $this->integer(),
            'attrib' => $this->integer(),
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'date' => $this->string(),
            'modified' => $this->integer(),
            'deviceid' => $this->string(),
            'data_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-data-data_id',
            '{{%wth_workout_objects}}',
            'data_id',
            'wth_workout_object_datas',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_workout_objects}}');
    }
}
