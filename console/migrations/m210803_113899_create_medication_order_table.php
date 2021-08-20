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
            'encounter__display' => $this->string(),
            'encounter__reference' => $this->string(),
            'medicationreference__display' => $this->string(),
            'medicationreference__reference' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'prescriber__display' => $this->string(),
            'prescriber__reference' => $this->string(),
            'reasonended_text' => $this->string(),
            'identifier' => $this->string()->notNull(),
            'resourcetype' => $this->string()->notNull(),
            'status' => $this->string()->notNull(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
        ]);

        $this->createTable('{{%dosage_instruction}}', [
            'id' => $this->primaryKey(),
            'dosequantity__code' => $this->string(),
            'dosequantity__system' => $this->string(),
            'dosequantity__unit' => $this->string(),
            'dosequantity__value' => $this->integer(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->string(),
            'timing__repeat__periodunits' => $this->string(),
            'medication_order_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-dosage_instruction-medication_order_id',
            'dosage_instruction',
            'medication_order_id',
            'medication_order',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%coding}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(),
            'display' => $this->string(),
            'system' => $this->string(),
            'medication_order_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-coding-medication_order_id',
            'coding',
            'medication_order_id',
            'medication_order',
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
        $this->dropTable('{{%dosage_instruction}}');
        $this->dropTable('{{%coding}}');
    }
}
