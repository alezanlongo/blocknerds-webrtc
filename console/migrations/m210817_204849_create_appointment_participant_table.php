<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%appointments_particpants}}`.
 */
class m210817_204849_create_appointment_participant_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%appointment_participant}}', [
            'id'                => $this->primaryKey(),
            'status'            => $this->string(255)->null(),
            'actor__reference'  => $this->string(255)->null(),
            'actor__display'    => $this->string(255)->null(),
            'appointment_id'    => $this->integer()->null()
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx_appointment_participant_01',
            '{{%appointment_participant}}',
            'appointment_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_appointment_participant_01',
            '{{%appointment_participant}}',
            'appointment_id',
            'appointment',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%appointment_particpant}}');
    }
}
