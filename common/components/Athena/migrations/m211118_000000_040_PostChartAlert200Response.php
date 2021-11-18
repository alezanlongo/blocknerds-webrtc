<?php

/**
 * Table for PostChartAlert200Response
 */
class m211118_000000_040_PostChartAlert200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_chart_alert200_responses}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_chart_alert200_responses}}');
    }
}
