<?php

/**
 * Table for Frequency
 */
class m211201_000000_115_Frequency extends \yii\db\Migration
{
    public function up()
    {
        $this->createTable('{{%frequencies}}', [
            'frequency' => $this->string(),
            'externalId' => $this->string(),
            'id' => $this->primaryKey(),
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%frequencies}}');
    }
}
