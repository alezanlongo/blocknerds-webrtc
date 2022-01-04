<?php

/**
 * Table for MedicalHistoryQuestion
 */
class m211222_000000_146_MedicalHistoryQuestion extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_history_questions}}', [
            'answer' => $this->string(),
            'codeset' => $this->string(),
            'description' => $this->string(),
            'diagnosiscode' => $this->string(),
            'note' => $this->string(),
            'question' => $this->string(),
            'questionid' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%medical_history_questions}}');
    }
}
