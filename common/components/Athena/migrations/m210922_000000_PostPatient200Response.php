<?php

/**
 * Table for PostPatient200Response
 */
class m210922_000000_PostPatient200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_patient200_responses}}', [
            'errormessage' => $this->string(),
            'patientid' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%post_patient200_responses}}');
    }
}
