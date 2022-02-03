<?php

/**
 * Table for user_device_object
 */
class m220203_000000_031_user_device_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_device_objects}}', [
            'type' => $this->string(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'battery' => $this->string(),
            'deviceid' => $this->string(),
            'hash_deviceid' => $this->string(),
            'timezone' => $this->string(),
            'last_session_date' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_device_objects}}');
    }
}