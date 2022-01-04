<?php

/**
 * Table for MedicalHistoryConfiguration
 */
class m211222_000000_151_MedicalHistoryConfiguration extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_history_configurations}}', [
            'totalcount' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medical_history_configurations}}');
    }
}
