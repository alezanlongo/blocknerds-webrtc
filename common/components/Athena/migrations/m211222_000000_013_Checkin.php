<?php

/**
 * Table for Checkin
 */
class m211222_000000_013_Checkin extends \yii\db\Migration
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
