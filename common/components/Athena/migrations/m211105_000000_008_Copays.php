<?php

/**
 * Table for Copays
 */
class m211105_000000_008_Copays extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%copays}}', [
            'copayamount' => $this->string(),
            'copaytype' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%copays}}');
    }
}
