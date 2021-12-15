<?php

/**
 * Table for ChangedSubscription200Response
 */
class m211214_000000_024_ChangedSubscription200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%changed_subscription200_responses}}', [
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%changed_subscription200_responses}}');
    }
}