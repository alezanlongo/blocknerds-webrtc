<?php

/**
 * Table for PostMedication200Response
 */
class m211202_000000_069_PostMedication200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_medication200_responses}}', [
            'errormessage' => $this->string(),
            'medicationentryid' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_medication200_responses}}');
    }
}
