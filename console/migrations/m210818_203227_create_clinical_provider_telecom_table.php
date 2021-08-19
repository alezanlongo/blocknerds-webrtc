<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%clinicals_providers_telecoms}}`.
 */
class m210818_203227_create_clinical_provider_telecom_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
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
    }
}
