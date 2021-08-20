<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%medication_administration}}`.
 */
class m210804_151814_create_medication_administration_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%medication_administration}}', [
            'id' => $this->primaryKey(),
            'ext_id' => $this->string()->notNull(),
            'dosage__method__coding' => $this->json(),
            'dosage__method__text' => $this->string(),
            'dosage__quantity__code' => $this->string(),
            'dosage__quantity__system' => $this->string(),
            'dosage__quantity__unit' => $this->string(),
            'dosage__quantity__value' => $this->string(),
            'dosage__route__coding' => $this->json(),
            'dosage__route__text' => $this->string(),
            'dosage__sitecodeable__coding' => $this->json(),
            'dosage__sitecodeable__text' => $this->string(),
            'effectivetimeperiod__end' => $this->string(),
            'effectivetimeperiod__start' => $this->string(),
            'encounter__display' => $this->string(),
            'encounter__reference' => $this->string(),
            'identifier' => $this->json(),
            'patient__display' => $this->string(),
            'patient__reference' => $this->string(),
            'practitioner__display' => $this->string(),
            'practitioner__reference' => $this->string(),
            'prescription__display' => $this->string(),
            'prescription__reference' => $this->string(),
            'resourcetype' => $this->string(),
            'status' => $this->string(),
            'text__div' => $this->string(),
            'text__status' => $this->string(),
            'wasnotgiven' => $this->string(),


        ]);

        $this->createTable('{{%device}}', [
            'id' => $this->primaryKey(),
            'display' => $this->string(),
            'reference' => $this->string(),
            'medication_administration_id' => $this->integer(),

        ]);

        $this->addForeignKey(
            'fk-device-medication_administration_id',
            'device',
            'medication_administration_id',
            'medication_administration',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%reason_given}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'medication_administration_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reasongiven-reasongiven_id',
            'reason_given',
            'medication_administration_id',
            'medication_administration',
            'id',
            'CASCADE'
        );

        $this->createTable('{{%reason_notgiven}}', [
            'id' => $this->primaryKey(),
            'coding' => $this->json(),
            'text' => $this->string(),
            'medication_administration_id' => $this->integer(),
        ]);

        $this->addForeignKey(
            'fk-reason_notgiven-medication_administration_id',
            'reason_notgiven',
            'medication_administration_id',
            'medication_administration',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%medication_administration}}');
        $this->dropTable('{{%device}}');
        $this->dropTable('{{%reason_given}}');
        $this->dropTable('{{%reason_notgiven}}');
    }
}
