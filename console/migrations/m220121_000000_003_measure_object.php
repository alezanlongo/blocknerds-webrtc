<?php

/**
 * Table for measure_object
 */
class m220121_000000_003_measure_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_measure_objects}}', [
            'value' => $this->integer(),
            'type' => $this->integer(),
            'unit' => $this->integer(),
            'algo' => $this->integer(),
            'fm' => $this->integer(),
            'fw' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_measure_objects}}');
    }
}
