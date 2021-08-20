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

        $this->createTable('{{%clinical_provider_addresses}}', [
            'id'                    => $this->primaryKey(),
            'city'                  => $this->string(255)->null(),
            'postalcode'            => $this->string(255)->null(),
            'state'                 => $this->string(255)->null(),
            'line'                  => $this->json()->null(),
            'clinical_provider_id'  => $this->integer()->null(),
        ]);

        // creates index for column `author_id`
        $this->createIndex(
            'idx_clinical_provider_addresses_01',
            '{{%clinical_provider_addresses}}',
            'clinical_provider_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_clinical_provider_addresses_01',
            '{{%clinical_provider_addresses}}',
            'clinical_provider_id',
            'clinical_provider',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%clinical_provider_telecom}}', [
            'id'                    => $this->primaryKey(),
            'system'                => $this->string(255)->null(),
            'value'                 => $this->string(255)->null(),
            'clinical_provider_id'  => $this->integer()->null(),
        ]);


        // creates index for column `author_id`
        $this->createIndex(
            'idx_clinical_provider_telecom_01',
            '{{%clinical_provider_telecom}}',
            'clinical_provider_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk_clinical_provider_telecom_01',
            '{{%clinical_provider_telecom}}',
            'clinical_provider_id',
            'clinical_provider',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%clinical_provider_telecom}}');
        $this->dropTable('{{%clinical_provider_addresses}}');
        $this->dropTable('{{%clinical_provider}}');
    }
}
