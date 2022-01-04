<?php

/**
 * Table for AdminDocument200Response
 */
class m211222_000000_120_AdminDocument200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%admin_document200_responses}}', [
            'adminid' => $this->integer(),
            'errormessage' => $this->string(),
            'success' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%admin_document200_responses}}');
    }
}
