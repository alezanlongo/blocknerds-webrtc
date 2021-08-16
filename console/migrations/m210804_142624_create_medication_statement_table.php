<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medication_statement}}`.
 */
class m210804_142624_create_medication_statement_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medication_statement}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->string()->notNull(),
            'contained__code__coding__coding' => $this->json(),
            'contained__code__coding__text' => $this->string(),
            'contained__id' => $this->string()->notNull(),
            'contained_resourcetype' => $this->string()->notNull(),
            'dosage_id' => $this->integer()->notNull(),
            'effectiveperiod__end' => $this->string(),
            'effectiveperiond_start' => $this->string(),
            'identifier' => $this->json(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'resourcetype' => $this->string(),
            'status' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),

        ]);

        $this->addForeignKey(
            'fk-dosage-dosage_id',
            'medication_statement',
            'dosage_id',
            'dosage',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medication_statement}}');
    }
}
