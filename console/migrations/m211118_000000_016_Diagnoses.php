<?php

/**
 * Table for Diagnoses
 */
class m211118_000000_016_Diagnoses extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%diagnoses}}', [
            'description' => $this->string(),
            'diagnosisid' => $this->integer(),
            'errormessage' => $this->string(),
            'laterality' => $this->string(),
            'note' => $this->string(),
            'ranking' => $this->integer(),
            'snomedcode' => $this->integer(),
            'success' => $this->string(),
            'supportslaterality' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%diagnoses}}');
    }
}
