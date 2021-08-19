<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointments}}`.
 */
class m210817_204046_create_appointment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appointment}}', [
            'id'                => $this->primaryKey(),
            'ext_id'            => $this->string(255)->null(),
            'minutesduration'   => $this->integer()->null(),
            'resourcetype'      => $this->string(255)->null(),
            'status'            => $this->string(255)->null(),
            'start'             => $this->dateTime()->null(),
            'end'               => $this->dateTime()->null(),
            'type__text'        => $this->string(255)->null(),
            'practiceid'        => $this->integer()->null(),
            'departmentid'      => $this->integer()->null(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%appointment}}');
    }
}
