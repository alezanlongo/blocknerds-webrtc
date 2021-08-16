<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medication_order}}`.
 */
class m210803_113899_create_medication_order_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medication_order}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->string()->notNull(),
            'dateendeed' => $this->string()->notNull(),
            'datewritten' => $this->string()->notNull(),
            'dispenserequest__numberofrepeatsallowed' => $this->integer(),
            'dispenserequest__quantity__code' => $this->string(),
            'dispenserequest__quantity__system' => $this->string(),
            'dispenserequest__quantity__unit' => $this->string(),
            'dispenserequest__quantity__number' => $this->integer(),
            'dosageinstruction_id' => $this->integer()->notNull(),
            'encounter__display' => $this->string(),
            'encounter__reference' => $this->string(),
            'medicationreference__display' => $this->string(),
            'medicationreference__reference' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'prescriber__display' => $this->string(),
            'prescriber__reference' => $this->string(),
            'reasonended_coding_id' => $this->integer(),
            'reasonended_text' => $this->string(),
            'identifier' => $this->string()->notNull(),
            'resourcetype' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
        ]);

        $this->addForeignKey(
            'fk-medication_order-dosageinstruction_id',
            'medication_order',
            'dosageinstruction_id',
            'dosage_instruction',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-medication_order-reasonended_coding_id',
            'medication_order',
            'reasonended_coding_id',
            'coding',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medication_order}}');
    }
}
