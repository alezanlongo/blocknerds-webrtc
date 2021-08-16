<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%device}}`.
 */
class m210804_151808_create_device_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%device}}', [
            'id' => $this->primaryKey(),
            'display' => $this->string(),
            'reference' => $this->string(),

        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%device}}');
    }
}
