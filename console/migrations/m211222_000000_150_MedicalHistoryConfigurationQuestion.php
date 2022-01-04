<?php

/**
 * Table for MedicalHistoryConfigurationQuestion
 */
class m211222_000000_150_MedicalHistoryConfigurationQuestion extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_history_configuration_questions}}', [
            'deleted' => $this->string(),
            'diagnosiscode' => $this->string(),
            'ordering' => $this->float(),
            'question' => $this->string(),
            'questionid' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medical_history_configuration_questions}}');
    }
}
