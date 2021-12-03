<?php

/**
 * Table for Vitals
 */
class m211202_000000_056_Vitals extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%vitals}}', [
            'encounterVital_id' => $this->integer(),
            'abbreviation' => $this->string(),
            'key' => $this->string(),
            'ordering' => $this->integer(),
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
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-encounterVital-encounterVital_id',
            '{{%vitals}}',
            'encounterVital_id',
            'encounter_vitals',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%vitals}}');
    }
}
