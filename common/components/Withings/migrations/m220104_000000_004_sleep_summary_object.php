<?php

/**
 * Table for sleep_summary_object
 */
class m220104_000000_004_sleep_summary_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%sleep_summary_objects}}', [
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
            '{{%sleep_summary_objects}}',
            'data_id',
            'datas',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%sleep_summary_objects}}');
    }
}
