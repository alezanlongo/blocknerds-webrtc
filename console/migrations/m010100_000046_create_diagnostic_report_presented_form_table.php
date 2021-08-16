<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000046_create_diagnostic_report_presented_form_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%diagnostic_report_presented_form}}', [
            'id' => $this->primaryKey(),
            'contentType' => $this->string(),
            'language' => $this->string(),
            'data' => $this->string(),
            'uri' => $this->string(),
            'size' => $this->integer(),
            'hash' => $this->string(),
            'title' => $this->string(),
            'creation' => $this->string(),
            'diagnostic_report_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-presented_form-diagnostic_report_id',
            'diagnostic_report_presented_form',
            'diagnostic_report_id',
            'diagnostic_report',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%diagnostic_report_presented_form}}');
    }
}
