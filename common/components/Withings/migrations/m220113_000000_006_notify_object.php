<?php

/**
 * Table for notify_object
 */
class m220113_000000_006_notify_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%notify_objects}}', [
            'appli' => $this->integer(),
            'callbackurl' => $this->string(),
            'expires' => $this->integer(),
            'comment' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%notify_objects}}');
    }
}
