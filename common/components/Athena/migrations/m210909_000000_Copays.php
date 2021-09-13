<?php

/**
 * Table for Copays
 */
class m210909_000000_Copays extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%copays}}', [
            'copayamount' => text,
            'copaytype' => float,
            'external_id' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%copays}}');
    }
}
