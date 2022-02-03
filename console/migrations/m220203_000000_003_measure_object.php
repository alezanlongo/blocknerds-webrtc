<?php

/**
 * Table for measure_object
 */
class m220203_000000_003_measure_object extends \yii\db\Migration
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
            'measuregrp_object_id' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-measuregrp_object-measuregrp_object_id',
            '{{%wth_measure_objects}}',
            'measuregrp_object_id',
            'wth_measuregrp_objects',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%wth_measure_objects}}');
    }
}
