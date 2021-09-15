<?php

/**
 * Table for Checkin
 */
class m210909_000000_Checkin extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%checkins}}', [
            'message' => text,
            'success' => text,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%checkins}}');
    }
}
