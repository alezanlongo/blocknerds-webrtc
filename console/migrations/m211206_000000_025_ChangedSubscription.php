<?php

/**
 * Table for ChangedSubscription
 */
class m211206_000000_025_ChangedSubscription extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%changed_subscriptions}}', [
            'status' => $this->string(),
            'subscriptions' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%changed_subscriptions}}');
    }
}
