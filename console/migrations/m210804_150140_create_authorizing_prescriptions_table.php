<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%authorizing_prescriptions}}`.
 */
class m210804_150140_create_authorizing_prescriptions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%authorizing_prescriptions}}', [
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
        $this->dropTable('{{%authorizing_prescriptions}}');
    }
}
