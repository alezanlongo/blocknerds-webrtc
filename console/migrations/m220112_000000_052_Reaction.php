<?php

/**
 * Table for Reaction
 */
class m220112_000000_052_Reaction extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%reactions}}', [
            'reactionname' => $this->string(),
            'severity' => $this->string(),
            'severitysnomedcode' => $this->integer(),
            'snomedcode' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%reactions}}');
    }
}