<?php

/**
 * Table for dropshipment_getorderstatus
 */
class m220203_000000_025_dropshipment_getorderstatus extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%wth_dropshipment_getorderstatuses}}', [
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%wth_dropshipment_getorderstatuses}}');
    }
}
