<?php

/**
 * Table for MedicalHistoryQuestion
 */
class m220112_000000_147_MedicalHistoryQuestion extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%medical_history_questions}}', [
            'medicalHistory_id' => $this->integer(),
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

        $this->addForeignKey(
            'fk-medicalHistory-medicalHistory_id',
            '{{%medical_history_questions}}',
            'medicalHistory_id',
            'medical_histories',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('{{%medical_history_questions}}');
    }
}
