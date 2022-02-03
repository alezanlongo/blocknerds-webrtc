<?php

/**
 * Table for notify_object
 */
class m220203_000000_014_notify_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_notify_objects}}', [
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
        $this->dropTable('{{%wth_notify_objects}}');
    }
}
