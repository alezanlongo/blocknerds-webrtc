<?php

/**
 * Table for Event
 */
class m211105_000000_046_Event extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%events}}', [
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

    }

    public function down()
    {
        $this->dropTable('{{%events}}');
    }
}
