<?php

/**
 * Table for workout_object
 */
class m220113_000000_005_workout_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%workout_objects}}', [
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
            '{{%workout_objects}}',
            'data_id',
            'datas',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%workout_objects}}');
    }
}
