<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medication_dispense}}`.
 */
class m210804_150143_create_medication_dispense_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medication_dispense}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->string()->notNull(),
            'authorizingprescriptions_id' => $this->integer()->notNull(),
            'dayssuply__code' => $this->string(),
            'dayssuply__system' => $this->string(),
            'dayssuply__unit' => $this->string(),
            'dayssuply__value' => $this->integer(),
            'destination__display' => $this->string(),
            'destination__reference' => $this->string(),
            'dispenser__display' => $this->string(),
            'dispenser__reference' => $this->string(),
            'dosageinstruction_id' => $this->integer(),
            'identifier' => $this->string(),
            'medicationreference__display' => $this->string(),
            'medicationreference__reference' => $this->string(),
            'note' => $this->string(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'quantity__code' => $this->string(),
            'quantity__system' => $this->string(),
            'quantity__unit' => $this->string(),
            'quantity__value' => $this->integer(),
            'receiver__display' => $this->string(),
            'receiver__reference' => $this->string(),
            'resourcetype' => $this->string(),
            'status' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
            'type__coding' => $this->json(),
            'type__text' => $this->string(),
            'whenhandedover' => $this->string(),
            'whenprepared' => $this->string(),

        ]);

        $this->addForeignKey(
            'fk-authorizingprescriptions-authorizingprescriptions_id',
            'medication_dispense',
            'authorizingprescriptions_id',
            'authorizing_prescriptions',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-dosageinstruction-dosageinstruction_id',
            'medication_dispense',
            'dosageinstruction_id',
            'dosage_instruction',
            'id',
            'CASCADE'
        );

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medication_dispense}}');
    }
}
