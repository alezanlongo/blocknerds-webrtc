<?php

/**
 * Table for dropshipment_update
 */
class m220203_000000_026_dropshipment_update extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_updates}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_updates}}');
    }
}