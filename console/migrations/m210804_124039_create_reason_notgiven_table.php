<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reason_notgiven}}`.
 */
class m210804_124039_create_reason_notgiven_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reason_notgiven}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%reason_notgiven}}');
    }
}
