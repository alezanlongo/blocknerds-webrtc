<?php

/**
 * Table for Event
 */
class m211214_000000_044_Event extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%events}}', [
            'problem_id' => $this->integer(),
            'createdby' => $this->string(),
            'createddate' => $this->string(),
            'encounterdate' => $this->string(),
            'enddate' => $this->string(),
            'eventtype' => $this->string(),
            'laterality' => $this->string(),
            'note' => $this->string(),
            'onsetdate' => $this->string(),
            'source' => $this->string(),
            'startdate' => $this->string(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        $this->addForeignKey(
            'fk-problem-problem_id',
            '{{%events}}',
            'problem_id',
            'problems',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%events}}');
    }
}
