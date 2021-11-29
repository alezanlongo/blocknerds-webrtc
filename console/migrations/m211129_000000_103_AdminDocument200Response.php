<?php

/**
 * Table for AdminDocument200Response
 */
class m211129_000000_103_AdminDocument200Response extends \yii\db\Migration
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
