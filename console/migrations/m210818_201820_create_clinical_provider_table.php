<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinicals_providers}}`.
 */
class m210818_201820_create_clinical_provider_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%clinical_provider}}', [
            'id'            => $this->primaryKey(),
            'resourcetype'  => $this->string(255)->null(),
            'status'        => $this->string(255)->null(),
            'practiceid'    => $this->integer()->null(),
            'departmentid'  => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinical_provider}}');
    }
}
