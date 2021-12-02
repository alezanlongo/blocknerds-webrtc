<?php

/**
 * Table for PutClosePatient200Response
 */
class m211202_000000_032_PutClosePatient200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%put_close_patient200_responses}}', [
            'error' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%put_close_patient200_responses}}');
    }
}
