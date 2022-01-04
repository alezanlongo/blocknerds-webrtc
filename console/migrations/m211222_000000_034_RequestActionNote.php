<?php

/**
 * Table for RequestActionNote
 */
class m211222_000000_034_RequestActionNote extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%request_action_notes}}', [
            'actionnote' => $this->string()->notNull(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%request_action_notes}}');
    }
}
