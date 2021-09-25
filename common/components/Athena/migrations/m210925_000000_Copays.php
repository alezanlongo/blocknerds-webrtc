<?php

/**
 * Table for Copays
 */
class m210925_000000_Copays extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%copays}}', [
            'copayamount' => $this->string(),
            'copaytype' => $this->float(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

        // TODO generate foreign keys
    }

    public function down()
    {
        $this->dropTable('{{%copays}}');
    }
}
