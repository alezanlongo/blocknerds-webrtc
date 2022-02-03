<?php

/**
 * Table for dropshipment_user
 */
class m220203_000000_023_dropshipment_user extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_users}}', [
            'code' => $this->string(),
            'external_id' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_users}}');
    }
}
