<?php

/**
 * Table for MedicationChanged
 */
class m211202_000000_040_MedicationChanged extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medication_changeds}}', [
            'totalcount' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medication_changeds}}');
    }
}
