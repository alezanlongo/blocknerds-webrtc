<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%practice_configuration}}`.
 */
class m210818_204153_create_practice_configuration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%practice_configuration}}', [
            'id'                => $this->primaryKey(),
            'resourcetype'      => $this->string(255)->null(),
            'name'              => $this->string(255)->null(),
            'practiceid'        => $this->integer()->null(),
            'departmentid'      => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%practice_configuration}}');
    }
}
