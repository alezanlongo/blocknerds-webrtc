<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000045_create_diagnostic_report_coded_diagnosis_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%diagnostic_report_coded_diagnosis}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'diagnostic_report_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-coded_diagnosis-diagnostic_report_id',
            'diagnostic_report_coded_diagnosis',
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
        $this->dropTable('{{%diagnostic_report_coded_diagnosis}}');
    }
}
