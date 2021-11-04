<?php

/**
 * Table for ActionNote
 */
class m211026_000000_039_ActionNote extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%action_notes}}', [
            'actionnote' => $this->string(),
            'assignedto' => $this->string(),
            'createdby' => $this->string(),
            'createddatetime' => $this->string(),
            'patientid' => $this->integer(),
            'priority' => $this->integer(),
            'status' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%action_notes}}');
    }
}
