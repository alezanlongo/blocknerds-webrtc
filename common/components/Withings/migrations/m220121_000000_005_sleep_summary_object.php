<?php

/**
 * Table for sleep_summary_object
 */
class m220121_000000_005_sleep_summary_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_sleep_summary_objects}}', [
            'timezone' => $this->string(),
            'model' => $this->integer(),
            'model_id' => $this->integer(),
            'startdate' => $this->integer(),
            'enddate' => $this->integer(),
            'date' => $this->string(),
            'created' => $this->integer(),
            'modified' => $this->integer(),
            'data_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-data-data_id',
            '{{%wth_sleep_summary_objects}}',
            'data_id',
            'wth_sleep_summary_object_datas',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_sleep_summary_objects}}');
    }
}
