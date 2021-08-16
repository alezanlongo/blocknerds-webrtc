<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%coding}}`.
 */
class m210803_113891_create_coding_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%coding}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'display' => $this->string(),
            'system' => $this->string(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%coding}}');
    }
}
