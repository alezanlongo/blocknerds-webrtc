<?php

/**
 * Table for MedicalHistoryConfigurationQuestion
 */
class m220112_000000_150_MedicalHistoryConfigurationQuestion extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_history_configuration_questions}}', [
            'deleted' => $this->string(),
            'diagnosiscode' => $this->string(),
            'ordering' => $this->float(),
            'question' => $this->string(),
            'questionid' => $this->float(),
            'answer' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medical_history_configuration_questions}}');
    }
}
