<?php

/**
 * Table for Readings
 */
class m211115_000000_059_Readings extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%readings}}', [
            'clinicalelementid' => $this->string(),
            'code' => $this->string(),
            'codedescription' => $this->string(),
            'codeset' => $this->string(),
            'createdby' => $this->string(),
            'createddate' => $this->string(),
            'isgraphable' => $this->string(),
            'percentilespec' => $this->string(),
            'readingid' => $this->integer(),
            'readingtaken' => $this->string(),
            'source' => $this->string(),
            'sourceid' => $this->integer(),
            'unit' => $this->string(),
            'value' => $this->string(),
            'vitalid' => $this->integer(),
            'abbreviation' => $this->string(),
            'key' => $this->string(),
            'ordering' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%readings}}');
    }
}
