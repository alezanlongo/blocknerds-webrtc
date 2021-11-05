<?php

/**
 * Table for RequestChartAlert
 */
class m211105_000000_039_RequestChartAlert extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_chart_alerts}}', [
            'departmentid' => $this->integer()->notNull(),
            'notetext' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_chart_alerts}}');
    }
}
