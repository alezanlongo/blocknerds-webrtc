<?php

/**
 * Table for user_device_mac_object
 */
class m220121_000000_010_user_device_mac_object extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_device_mac_objects}}', [
            'mac_address' => $this->string(),
            'type' => $this->string(),
            'model' => $this->string(),
            'model_id' => $this->integer(),
            'battery' => $this->string(),
            'deviceid' => $this->string(),
            'timezone' => $this->string(),
            'last_session_date' => $this->integer(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_device_mac_objects}}');
    }
}
