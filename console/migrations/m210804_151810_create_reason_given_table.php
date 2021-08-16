<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%reason_given}}`.
 */
class m210804_151810_create_reason_given_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%reason_given}}', [
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
        $this->dropTable('{{%reason_given}}');
    }
}
