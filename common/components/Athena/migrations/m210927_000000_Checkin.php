<?php

/**
 * Table for Checkin
 */
class m210927_000000_Checkin extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%checkins}}', [
            'message' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%checkins}}');
    }
}
