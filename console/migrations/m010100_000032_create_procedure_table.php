<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%entity}}`.
 */
class m010100_000032_create_procedure_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%procedure}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->integer(),
            'identifier__system' => $this->string(),
            'identifier__use' => $this->string(),
            'identifier__value' => $this->string(),
            'status' => $this->string(),
            'notPerformed' => $this->json(),
            'code__coding' => $this->json(),
            'code__text' => $this->string(),
            'category__coding' => $this->json(),
            'category__text' => $this->string(),
            'performedDatetime' => $this->string(),
            'subject__display' => $this->json(),
            'subject__reference' => $this->string(),
            'reasonCodeableConcept__coding' => $this->json(),
            'reasonCodeableConcept__text' => $this->string(),
            'performedDateTime' => $this->string(),
            'performedPeriod__start' => $this->string(),
            'performedPeriod__end' => $this->string(),
            'outcome__coding' => $this->json(),
            'outcome__text' => $this->string(),
        ]);

        $this->createTable('{{%procedure_reason_not_performed}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reason_not_performed-procedure_id',
            'procedure_reason_not_performed',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_body_site}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-body_site-procedure_id',
            'procedure_body_site',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_performer}}', [
            'id' => $this->primaryKey(),
            'role__coding' => $this->json(),
            'role__text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-performer-procedure_id',
            'procedure_performer',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_outcome}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-outcome-procedure_id',
            'procedure_outcome',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_complication}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-complication-procedure_id',
            'procedure_complication',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_follow_up}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-follow_up-procedure_id',
            'procedure_follow_up',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%procedure_notes}}', [
            'id' => $this->primaryKey(),
            'authorReference' => $this->json(),
            'authorString' => $this->string(),
            'time' => $this->string(),
            'text' => $this->string(),
            'procedure_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-notes-procedure_id',
            'procedure_notes',
            'procedure_id',
            'procedure',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%procedure_notes}}');
        $this->dropTable('{{%procedure_follow_up}}');
        $this->dropTable('{{%procedure_complication}}');
        $this->dropTable('{{%procedure_outcome}}');
        $this->dropTable('{{%procedure_performer}}');
        $this->dropTable('{{%procedure_body_site}}');
        $this->dropTable('{{%procedure_reason_not_performed}}');
        $this->dropTable('{{%procedure}}');
    }
}
