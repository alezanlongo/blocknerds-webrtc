<?php

/**
 * Table for ChartAlert
 */
class m211129_000000_041_ChartAlert extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%chart_alerts}}', [
            'lastmodified' => $this->string(),
            'lastmodifiedby' => $this->string(),
            'notetext' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%chart_alerts}}');
    }
}
