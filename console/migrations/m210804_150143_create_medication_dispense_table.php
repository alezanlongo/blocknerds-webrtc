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
            'dayssuply__code' => $this->string(),
            'dayssuply__system' => $this->string(),
            'dayssuply__unit' => $this->string(),
            'dayssuply__value' => $this->integer(),
            'destination__display' => $this->string(),
            'destination__reference' => $this->string(),
            'dispenser__display' => $this->string(),
            'dispenser__reference' => $this->string(),
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

        $this->createTable('{{%authorizing_prescriptions}}', [
            'id' => $this->primaryKey(),
            'display' => $this->string(),
            'reference' => $this->string(),
            'medication_dispense_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-authorizing_prescriptions-medication_dispense_id',
            'authorizing_prescriptions',
            'medication_dispense_id',
            'medication_dispense',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%dosage_instructions}}', [
            'id' => $this->primaryKey(),
            'additionalinstructions__coding' => $this->json(),
            'additionalinstructions__text' => $this->string(),
            'text' => $this->string(),
            'timing__event' => $this->json(),
            'timing__repeat__frequency' => $this->integer(),
            'timing__repeat__period' => $this->integer(),
            'timing__repeat__periodunits' => $this->string(),
            'medication_dispense_id' => $this->integer(),

        ]);

        $this->addForeignKey(
            'fk-dosage_instructions-medication_dispense_id',
            'dosage_instructions',
            'medication_dispense_id',
            'medication_dispense',
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
        $this->dropTable('{{%authorizing_prescriptions}}');
        $this->dropTable('{{%dosage_instructions}}');
    }
}
