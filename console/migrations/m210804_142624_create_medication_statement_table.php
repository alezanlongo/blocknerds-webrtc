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

        $this->createTable('{{%dosage}}', [
            'id' => $this->primaryKey(),
            'route__coding__coding' => $this->json(),
            'route__coding__text' => $this->string(),
            'route__text' => $this->string(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->integer(),
            'timing__repeat__periodunits' => $this->string(),
            'medication_statement_id' => $this->integer(),

        ]);

        $this->addForeignKey(
            'fk-dosage-medication_statement_id',
            'dosage',
            'medication_statement_id',
            'medication_statement',
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
        $this->dropTable('{{%dosage}}');
    }
}
