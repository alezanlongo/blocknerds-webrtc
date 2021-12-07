<?php

/**
 * Table for PostActionNote200Response
 */
class m211206_000000_035_PostActionNote200Response extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%post_action_note200_responses}}', [
            'errormessage' => $this->string(),
            'newdocumentid' => $this->string(),
            'success' => $this->string(),
            'versiontoken' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%post_action_note200_responses}}');
    }
}
