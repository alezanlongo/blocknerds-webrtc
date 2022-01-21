<?php

/**
 * Table for user_getdevice
 */
class m220121_000000_028_user_getdevice extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_user_getdevices}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_user_getdevices}}');
    }
}
