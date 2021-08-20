<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000044_create_diagnostic_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%diagnostic_report}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'category__coding' => $this->json(),
            'category__text' => $this->string(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'subject__display' => $this->json(),
            'subject__reference' => $this->string(),
            'encounter__display' => $this->json(),
            'encounter__reference' => $this->string(),
            'effectiveDateTime' => $this->string(),
            'effectivePeriod__start' => $this->string(),
            'effectivePeriod__end' => $this->string(),
            'issued' => $this->string(),
            'performer__display' => $this->json(),
            'performer__reference' => $this->string(),
            'request__display' => $this->json(),
            'request__reference' => $this->string(),
            'specimen__display' => $this->json(),
            'specimen__reference' => $this->string(),
            'result__display' => $this->json(),
            'result__reference' => $this->string(),
            'imagingStudy__display' => $this->json(),
            'imagingStudy__reference' => $this->string(),
            'conclusion' => $this->string(),
        ]);

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
        $this->dropTable('{{%diagnostic_report_coded_diagnosis}}');
        $this->dropTable('{{%diagnostic_report}}');
    }
}
